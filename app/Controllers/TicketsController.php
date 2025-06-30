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
        $data = $this->request->getPost();

        // Add validation here if needed

        $this->ticketModel->insert($data);

        return redirect()->to('/tickets')->with('message', 'Ticket created successfully');
    }

    // GET /tickets/{id}
    public function show($id = null)
    {
        $ticket = $this->ticketModel->find($id);

        if (!$ticket) {
            throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound("Ticket with ID $id not found");
        }

        return view('tickets/show', ['ticket' => $ticket]);
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
