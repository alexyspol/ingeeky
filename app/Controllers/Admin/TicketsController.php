<?php

namespace App\Controllers\Admin; // Notice the Admin namespace

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
        $this->ticketModel      = new TicketModel();
        $this->ticketMessageModel = new TicketMessageModel();
        $this->userModel        = new UserModel(); // Or whichever model represents your Shield users
    }

    // Apply filter to ensure only admins can access
    public function __before()
    {
        parent::__before(); // Call parent's __before if it exists
        // Example Shield filter (adjust as per your actual setup in Filters.php)
        // Ensure this controller is protected by 'group:admin' or 'permission:manage-tickets' filter
    }

    // GET /admin/tickets (Admin's view: all tickets)
    public function index()
    {
        // Admins can see all tickets, or filter by status, customer etc.
        $data['tickets'] = $this->ticketModel->findAll();
        // You might want to eager load customer data here for the list view
        // $data['tickets'] = $this->ticketModel->select('tickets.*, users.username as customer_name')
        //                                     ->join('users', 'users.id = tickets.customer_id', 'left')
        //                                     ->findAll();
        return view('admin/tickets/index', $data); // Assuming admin views are in admin/tickets
    }

    // GET /admin/tickets/new
    public function new()
    {
        // Admins need a list of customers to assign the ticket to
        $data['customers'] = $this->userModel->findAll(); // Fetch all users who can be customers
        return view('admin/tickets/new', $data);
    }

    // POST /admin/tickets
    public function create()
    {
        $post = $this->request->getPost();
        $adminId = auth()->id(); // Current logged-in admin's ID

        // Admins must provide a customer_id
        $this->ticketModel->setValidationRules([
            'customer_id' => 'required|integer|is_not_unique[users.id]', // Ensure customer exists
        ], $this->ticketModel->validationMessages); // Keep existing messages and add new ones if needed

        if (!$this->ticketModel->validate($post)) {
            return redirect()->back()->withInput()->with('errors', $this->ticketModel->errors());
        }

        // 1. Create the ticket
        $ticketData = [
            'title'       => $post['title'],
            'status'      => $post['status'] ?? 'open', // Admin can set initial status
            'created_by'  => $adminId,   // Admin creating the ticket
            'customer_id' => $post['customer_id'], // Admin assigns customer
            'product_id'  => $post['product_id'] ?? null,
        ];

        $ticketId = $this->ticketModel->insert($ticketData);

        if (!$ticketId) {
            return redirect()->back()->withInput()->with('error', 'Could not create ticket.');
        }

        // 2. Create the first message
        $messageData = [
            'ticket_id' => $ticketId,
            'user_id'   => $adminId, // Admin sending the message
            'message'   => $post['message'],
        ];

        if (!$this->ticketMessageModel->insert($messageData)) {
            return redirect()->to('/admin/tickets/' . $ticketId)->with('warning', 'Ticket created but initial message failed to save.');
        }

        return redirect()->to('/admin/tickets/' . $ticketId)->with('message', 'Ticket created successfully.');
    }

    // GET /admin/tickets/{id}
    public function show($id = null)
    {
        $ticket = $this->ticketModel->find($id);

        if (!$ticket) {
            throw PageNotFoundException::forPageNotFound("Ticket not found");
        }

        $messages = $this->ticketMessageModel->where('ticket_id', $id)
                                             ->orderBy('created_at', 'asc')
                                             ->findAll();

        // Optimized user fetching for messages
        $userIds = array_unique(array_column($messages, 'user_id'));
        $usersMap = [];
        if (!empty($userIds)) {
            $users = $this->userModel->find($userIds);
            foreach ($users as $user) {
                $usersMap[$user->id] = $user;
            }
        }

        $messagesWithSender = [];
        foreach ($messages as $msg) {
            $msg['sender'] = $usersMap[$msg['user_id']] ?? null;
            $messagesWithSender[] = $msg;
        }

        // Fetch the customer details for the ticket
        $customer = $this->userModel->find($ticket['customer_id']);

        return view('admin/tickets/show', [
            'ticket'   => $ticket,
            'messages' => $messagesWithSender,
            'customer' => $customer, // Pass customer details to the view
        ]);
    }

    // GET /admin/tickets/{id}/edit
    public function edit($id = null)
    {
        $ticket = $this->ticketModel->find($id);

        if (!$ticket) {
            throw PageNotFoundException::forPageNotFound("Ticket with ID $id not found");
        }

        $data['ticket'] = $ticket;
        $data['customers'] = $this->userModel->findAll(); // Admins can reassign customers
        return view('admin/tickets/edit', $data);
    }

    // PUT/PATCH /admin/tickets/{id}
    public function update($id = null)
    {
        $data = $this->request->getRawInput(); // For PUT/PATCH, use getRawInput()

        // Admin can update title, status, and customer_id
        $rules = [
            'title'       => 'permit_empty|min_length[3]|max_length[255]',
            'status'      => 'permit_empty|in_list[open,closed,pending,customer replied,awaiting customer]',
            'customer_id' => 'permit_empty|integer|is_not_unique[users.id]',
        ];

        if (!$this->validate($rules)) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        // Filter out only allowed fields for update
        $updateData = array_intersect_key($data, array_flip($this->ticketModel->getAllowedFields()));

        $this->ticketModel->update($id, $updateData);

        return redirect()->to("/admin/tickets/$id")->with('message', 'Ticket updated successfully');
    }

    // DELETE /admin/tickets/{id}
    public function delete($id = null)
    {
        $ticket = $this->ticketModel->find($id);

        if (!$ticket) {
            return redirect()->to('/admin/tickets')->with('error', 'Ticket not found.');
        }

        $this->ticketModel->delete($id);
        return redirect()->to('/admin/tickets')->with('message', 'Ticket deleted successfully');
    }

    // POST /admin/tickets/{id}/reply (Admin replying to a ticket)
    public function reply($ticketId = null)
    {
        $ticket = $this->ticketModel->find($ticketId);

        if (!$ticket) {
            throw PageNotFoundException::forPageNotFound("Ticket not found.");
        }

        $post = $this->request->getPost();
        $adminId = auth()->id();

        $rules = ['message' => 'required|min_length[1]'];
        if (!$this->validate($rules)) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        $messageData = [
            'ticket_id' => $ticketId,
            'user_id'   => $adminId,
            'message'   => $post['message'],
        ];

        $this->ticketMessageModel->insert($messageData);

        // Optionally update ticket status to 'awaiting customer' or similar
        $this->ticketModel->update($ticketId, ['status' => 'awaiting customer']);

        return redirect()->to("/admin/tickets/$ticketId")->with('message', 'Reply sent successfully.');
    }
}
