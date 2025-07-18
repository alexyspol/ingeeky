<?php

namespace App\Controllers;

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
        $userId = auth()->id();
        $data['tickets'] = $this->ticketModel->where('customer_id', $userId)->findAll();
        return view('tickets/index', $data);
    }

    // GET /tickets/new
    public function new()
    {
        return view('tickets/new');
    }

    // POST /tickets
    public function create()
    {
        $post = $this->request->getPost();
        $userId = auth()->id();

        // Validation (can be more robust using $this->validate() method)
        if (!$this->ticketModel->validate($post)) {
            return redirect()->back()->withInput()->with('errors', $this->ticketModel->errors());
        }

        // 1. Create the ticket
        $ticketData = [
            'title'       => $post['title'],
            'status'      => 'open',
            'created_by'  => $userId,   // Customer creating the ticket
            'customer_id' => $userId,   // Ticket is for this customer
            'product_id'  => $post['product_id'] ?? null, // Optional product association
        ];

        $ticketId = $this->ticketModel->insert($ticketData);

        if (!$ticketId) {
            return redirect()->back()->withInput()->with('error', 'Could not create ticket. Please try again.');
        }

        // 2. Create the first message
        $messageData = [
            'ticket_id' => $ticketId,
            'user_id'   => $userId, // Customer sending the message
            'message'   => $post['message'],
        ];

        if (!$this->ticketMessageModel->insert($messageData)) {
            // Optional: Handle if message insertion fails, maybe delete the ticket or log error
            return redirect()->to('/tickets/' . $ticketId)->with('warning', 'Ticket created but message failed to save.');
        }

        return redirect()->to('/tickets/' . $ticketId)->with('message', 'Ticket created successfully.');
    }

    // GET /tickets/{id}
    public function show($id = null)
    {
        $ticketModel = new TicketModel();
        $ticket = $ticketModel->find($id);

        if (!$ticket) {
            throw PageNotFoundException::forPageNotFound("Ticket not found");
        }

        $messageModel = new TicketMessageModel();
        $messages = $messageModel->where('ticket_id', $id)
                                ->orderBy('created_at', 'asc')
                                ->findAll();

        // Initialize an array to store unique user IDs from messages
        $userIds = [];
        foreach ($messages as $msg) {
            $userIds[] = $msg['user_id'];
        }

        // Get unique user IDs to avoid fetching the same user multiple times
        $userIds = array_unique($userIds);

        // Fetch user entities for all unique user IDs
        $userModel = new UserModel(); // Use your custom UserModel
        $users = $userModel->find($userIds); // find() can accept an array of IDs

        // Create a map of user_id to User entity for easy lookup
        $usersMap = [];
        foreach ($users as $user) {
            $usersMap[$user->id] = $user;
        }

        // Attach sender's profile data to each message
        // We'll iterate through messages and add a 'sender' key
        // containing the User entity (which has the getProfile() method)
        $messagesWithSender = [];
        foreach ($messages as $msg) {
            if (isset($usersMap[$msg['user_id']])) {
                $msg['sender'] = $usersMap[$msg['user_id']];
            } else {
                // Handle cases where a user might not be found (e.g., deleted user)
                $msg['sender'] = null;
            }
            $messagesWithSender[] = $msg;
        }

        return view('tickets/show', [
            'ticket'   => $ticket,
            'messages' => $messagesWithSender,
        ]);
    }

    // GET /tickets/{id}/edit
    public function edit($id = null)
    {
        $ticket = $this->ticketModel->find($id);

        if (!$ticket) {
            throw PageNotFoundException::forPageNotFound("Ticket with ID $id not found");
        }

        return view('tickets/edit', ['ticket' => $ticket]);
    }

    // PUT/PATCH /tickets/{id}
    public function update($id = null)
    {
        $data = $this->request->getRawInput();

        // Add validation here if needed

        $this->ticketModel->update($id, $data);

        return redirect()->to("/tickets/$id")->with('message', 'Ticket updated successfully');
    }

    // DELETE /tickets/{id}
    public function delete($id = null)
    {
        $this->ticketModel->delete($id);
        return redirect()->to('/tickets')->with('message', 'Ticket deleted successfully');
    }
}
