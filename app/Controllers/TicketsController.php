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
        if(auth()->user()->can('admin.access')) {
            $data['tickets'] = $this->ticketModel->findAll();
        } else {
            $userId = auth()->id();
            $data['tickets'] = $this->ticketModel->where('customer_id', $userId)->findAll();
        }

        return view('tickets/index', $data);
    }

    // GET /tickets/new
    public function new()
    {
        helper('form');

        if(auth()->user()->can('admin.access')) {
            $data['customers'] = $this->userModel->getUsersByGroupName('user');
        }

        return view('tickets/new', $data ?? []);
    }

    // POST /tickets
    public function create()
    {
        $post = $this->request->getPost();

        if(auth()->user()->can('admin.access')) {
            $post['customer_id'] = (int) $post['customer_id'];
        } else {
            $post['customer_id'] = auth()->id();
        }

        if (!$this->ticketModel->validate($post)) {
            return redirect()->back()->withInput()->with('errors', $this->ticketModel->errors());
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

        // 6. Redirect to the ticket's show page with a success message
        // Note the corrected route name 'tickets.show'
        return redirect()->to(url_to('tickets.show', $ticketId))->with('message', 'Ticket updated successfully.');
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
}
