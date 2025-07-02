<?php

namespace App\Controllers;

use App\Models\TicketModel;

class TicketsController extends BaseController
{
    protected $ticketModel;

    public function __construct()
    {
        $this->ticketModel = new TicketModel();
    }

    // GET /tickets
    public function index()
    {
        $data['tickets'] = $this->ticketModel->findAll();
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

        // Get the current user ID (using Shield)
        $userId = auth()->id();

        // 1. Create the ticket
        $ticketData = [
            'title'      => $post['title'],
            'status'     => $post['status'],
            'created_by' => $userId,
        ];

        $ticketModel = new \App\Models\TicketModel();
        $ticketId = $ticketModel->insert($ticketData);

        if (!$ticketId) {
            return redirect()->back()->withInput()->with('error', 'Could not create ticket.');
        }

        // 2. Create the first message
        $messageData = [
            'ticket_id' => $ticketId,
            'user_id'   => $userId,
            'message'   => $post['message'],
        ];

        $messageModel = new \App\Models\TicketMessageModel();
        $messageModel->insert($messageData);

        return redirect()->to('/tickets/' . $ticketId)->with('message', 'Ticket created successfully.');
    }

    // GET /tickets/{id}
    public function show($id = null)
    {
        $ticketModel = new \App\Models\TicketModel();
        $ticket = $ticketModel->find($id);

        if (!$ticket) {
            throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound("Ticket not found");
        }

        $messageModel = new \App\Models\TicketMessageModel();
        $messages = $messageModel->where('ticket_id', $id)
                                ->orderBy('created_at', 'asc')
                                ->findAll();

        return view('tickets/show', [
            'ticket'   => $ticket,
            'messages' => $messages,
        ]);
    }

    // GET /tickets/{id}/edit
    public function edit($id = null)
    {
        $ticket = $this->ticketModel->find($id);

        if (!$ticket) {
            throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound("Ticket with ID $id not found");
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
