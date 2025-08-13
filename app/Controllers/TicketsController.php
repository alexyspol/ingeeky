<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use CodeIgniter\Exceptions\PageNotFoundException;
use App\Models\TicketModel;
use App\Models\UserModel;
use App\Models\TicketMessageModel;

class TicketsController extends BaseController
{
    protected $ticketModel;
    protected $ticketMessageModel;
    protected $userModel;

    public function __construct()
    {
        $this->ticketModel        = new TicketModel();
        $this->ticketMessageModel = new TicketMessageModel();
        $this->userModel          = new UserModel(); // Or whichever model represents your Shield users
    }

    // GET /tickets
    public function index()
    {
        // Get the current authenticated user.
        $user = auth()->user();

        // Initialize the query builder.
        $query = $this->ticketModel;

        // Check for admin permission first, which has the highest priority.
        if ($user->can('admin.access')) {
            // Admins can see all tickets.
            $query = $query->findAll();
        } elseif ($user->inGroup('user')) {
            // 'user' group members (customers) can only see tickets they own.
            $query = $query->where('customer_id', $user->id)->findAll();
        } else {
            // All other users are assumed to be staff. Their groups directly correspond to departments.
            $departmentGroups = $user->getGroups();
            
            // We filter out the 'user' group just in case to ensure we only get department names.
            $departmentGroups = array_diff($departmentGroups, ['user']);

            if (!empty($departmentGroups)) {
                // Use a 'whereIn' clause to get all tickets for all of the user's department groups.
                // For example, if a user's role is 'support', this will query for tickets where department = 'support'.
                $query = $query->whereIn('department', $departmentGroups)->findAll();
            } else {
                // If the user isn't in any department groups, return an empty array.
                $query = [];
            }
        }

        $data['tickets'] = $query;

        return view('tickets/index', $data);
    }

    // GET /tickets/new
    public function new()
    {
        helper('form');

        if(auth()->user()->can('tickets.assign_customer')) {
            $data['customers'] = $this->userModel->getUsersByGroupName('user');
        }

        $data['departments'] = $this->getDepartments();

        return view('tickets/new', $data ?? []);
    }

    // POST /tickets
    public function create()
    {
        $post = $this->request->getPost();
        $post['customer_id'] = (int) $post['customer_id'];

        if(auth()->user()->can('admin.access')) {
            $post['customer_id'] = (int) $post['customer_id'];
        } else {
            $post['customer_id'] = auth()->id();
        }

        $authGroups = config('AuthGroups');
        $departmentGroupNames = [];

        foreach ($authGroups->groups as $groupName => $groupData) {
            if (isset($groupData['department'])) {
                $departmentGroupNames[] = $groupName;
            }
        }

        // Convert the array of department group names into a comma-separated string
        $departmentList = implode(',', $departmentGroupNames);

        $rules = $this->ticketModel->getValidationRulesByGroupName('create');
        $rules['department'] .= "|in_list[$departmentList]";

        if (!$this->validate($rules)) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        $creatorId = auth()->id();

        // Start a database transaction
        $db = \Config\Database::connect();
        $db->transBegin();

        // 1. Create the ticket
        $ticketData = [
            'title'       => $post['title'],
            'status'      => 'open',
            'priority'    => $post['priority'],
            'created_by'  => $creatorId,
            'customer_id' => $post['customer_id'],
            'department'  => $post['department'],
        ];

        $ticketId = $this->ticketModel->insert($ticketData);

        if (!$ticketId) {
            return redirect()->back()->withInput()->with('error', 'Could not create ticket.');
        }

        // 2. Create the first message
        $messageData = [
            'ticket_id' => $ticketId,
            'user_id'   => $creatorId,
            'message'   => $post['message'],
        ];

        $messageId = $this->ticketMessageModel->insert($messageData);

        // If message creation fails, rollback and return
        if (!$messageId) {
            $db->transRollback();
            return redirect()->back()->withInput()->with('error', 'Ticket created but initial message failed to save. Rolled back.');
        }

        // If both operations succeeded, commit the transaction
        $db->transCommit();

        log_activity("created <a href='" . url_to('tickets.show', $ticketId) . "'>Ticket #{$ticketId}</a>");

        return redirect()->to(url_to('tickets.index', $ticketId))->with('message', 'Ticket created successfully.');
    }

    // GET /tickets/{id}
    public function show($ticketId = null)
    {
        $ticket = $this->ticketModel->find($ticketId);

        if (!$ticket) {
            throw PageNotFoundException::forPageNotFound("Ticket not found");
        }

        $messages = $this->ticketMessageModel->where('ticket_id', $ticketId)
                                             ->orderBy('created_at', 'asc')
                                             ->findAll();

        $userIds = array_unique(array_map(function ($message) {
            return $message['user_id'];
        }, $messages));

        $usersMap = [];
        if (!empty($userIds)) {
            $users = $this->userModel->find($userIds);
            foreach ($users as $user) {
                $usersMap[$user->id] = $user;
            }
        }

        // Attach the sender user object to each message
        foreach ($messages as $key => $msg) {
            // Check if the user exists in our map before attaching
            if (isset($usersMap[$msg['user_id']])) {
                // Attach the user object directly to the message object
                $messages[$key]['sender'] = $usersMap[$msg['user_id']];
            } else {
                // Handle cases where sender might not be found (optional)
                $messages[$key]['sender'] = null;
            }
        }

        log_activity("viewed <a href='" . url_to('tickets.show', $ticketId) . "'>Ticket #{$ticketId}</a>");

        return view('tickets/show', [
            'ticket'   => $ticket,
            'messages' => $messages,
        ]);
    }

    // GET /tickets/{id}/edit
    public function edit($ticketId = null)
    {
        helper('form');

        $ticket = $this->ticketModel->find($ticketId);

        if (!$ticket) {
            throw PageNotFoundException::forPageNotFound("Ticket with ID $ticketId not found");
        }

        $data['ticket'] = $ticket;

        if(auth()->user()->can('admin.access')) {
            $data['customers'] = $this->userModel->getUsersByGroupName('user'); // Admins can reassign customers
        }

        $data['departments'] = $this->getDepartments();

        return view('tickets/edit', $data);
    }

    // PATCH /tickets/{id}
    public function update($ticketId = null)
    {
        // 1. Get the raw input data from the PATCH request
        $data = $this->request->getRawInput();

        // 2. Find the ticket and perform a security check
        $ticket = $this->ticketModel->find($ticketId);

        if (empty($ticket)) {
            return redirect()->back()->with('error', 'Ticket not found.');
        }

        // You should add a permission check here, similar to your close() method
        // For example:
        // if (! auth()->user()->can('admin.access')) {
        //     return redirect()->back()->with('error', 'You do not have permission to update this ticket.');
        // }

        // 3. Validate the data using the 'update' validation group
        // Note the use of $this->ticketModel->validate() and $this->ticketModel->errors()
        if (!$this->ticketModel->validate($data, 'update')) {
            return redirect()->back()->with('errors', $this->ticketModel->errors());
        }

        // 4. Filter out any fields not allowed in the model
        $updateData = array_intersect_key($data, array_flip($this->ticketModel->getAllowedFields()));

        // 5. Update the ticket
        $this->ticketModel->update($ticketId, $updateData);

        log_activity("updated <a href='" . url_to('tickets.show', $ticketId) . "'>Ticket #{$ticketId}</a>");

        // 6. Check if the user has access to the ticket's new department
        $user = auth()->user();
        $redirectRoute = 'tickets.show';

        // If the 'department' was updated AND the user is not an admin,
        // check if the user is in the new department.
        if (isset($updateData['department']) && !$user->can('admin.access')) {
            $userGroups = $user->getGroups();
            // If the user's groups do not include the new department, redirect them
            // to the index page instead of the ticket page.
            if (!in_array($updateData['department'], $userGroups)) {
                $redirectRoute = 'tickets.index';
            }
        }

        // 7. Redirect to the appropriate page with a success message
        // Note the corrected route name 'tickets.show'
        return redirect()->to(url_to($redirectRoute, $ticketId))->with('message', 'Ticket updated successfully.');
        
        // 6. Redirect to the ticket's show page with a success message
        // Note the corrected route name 'tickets.show'
        // return redirect()->to(url_to('tickets.show', $ticketId))->with('message', 'Ticket updated successfully.');
    }

    // DELETE /tickets/{id}
    public function delete($ticketId = null)
    {
        $ticket = $this->ticketModel->find($ticketId);

        if (!$ticket) {
            return redirect()->to(url_to('tickets.index'))->with('error', 'Ticket not found.');
        }

        $this->ticketModel->delete($ticketId);

        log_activity("deleted <a href='" . url_to('tickets.show', $ticketId) . "'>Ticket #{$ticketId}</a>");

        return redirect()->to(url_to('tickets.index'))->with('message', 'Ticket deleted successfully');
    }

    // POST /tickets/{id}/reply
    public function reply($ticketId = null)
    {
        $ticket = $this->ticketModel->find($ticketId);

        if (!$ticket) {
            throw PageNotFoundException::forPageNotFound("Ticket not found.");
        }

        $post = $this->request->getPost();
        $creatorId = auth()->id();

        if (!$this->ticketMessageModel->validate($post)) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        $messageData = [
            'ticket_id' => $ticketId,
            'user_id'   => $creatorId,
            'message'   => $post['message'],
        ];

        $this->ticketMessageModel->insert($messageData);

        // Determine user group
        $user   = auth()->user();
        $groups = $user->getGroups();

        $newStatus = in_array('user', $groups)
            ? 'customer replied'
            : 'awaiting customer';

        // Update ticket status
        $this->ticketModel->update($ticketId, [
            'status' => $newStatus,
        ]);

        log_activity("replied to <a href='" . url_to('tickets.show', $ticketId) . "'>Ticket #{$ticketId}</a>");

        return redirect()->to(url_to('tickets.show', $ticketId))->with('message', 'Reply sent successfully.');
    }

    // PATCH /tickets/{id}/close
    public function close($ticketId)
    {
        $ticket = $this->ticketModel->find($ticketId);

        if ($ticket === null) {
            return redirect()->back()->with('error', 'Ticket not found.');
        }

        // Check if the ticket is already closed to avoid unnecessary updates
        if ($ticket['status'] === 'closed') {
            return redirect()->back()->with('message', 'This ticket is already closed.');
        }

        $updated = $this->ticketModel->update($ticketId, ['status' => 'closed']);

        if ($updated) {
            return redirect()->back()->with('message', 'Ticket closed successfully.');
        }

        log_activity("closed <a href='" . url_to('tickets.show', $ticketId) . "'>Ticket #{$ticketId}</a>");

        return redirect()->back()->with('error', 'An error occurred while trying to close the ticket.');
    }

    private function getDepartments()
    {
        $authGroups = config('AuthGroups');
        $departments = [];

        foreach ($authGroups->groups as $groupName => $groupData) {
            if (isset($groupData['department'])) {
                $departments[$groupName] = $groupData['department'];
            }
        }

        return $departments;
    }
}
