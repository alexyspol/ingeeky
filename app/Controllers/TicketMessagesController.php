<?php

namespace App\Controllers;

use App\Models\TicketModel;
use App\Models\TicketMessageModel;

class TicketMessagesController extends \App\Controllers\BaseController
{
    public function create()
    {
        // Define validation rules
        $rules = [
            'ticket_id' => 'required|is_natural_no_zero',
            'message'   => 'required|min_length[3]',
        ];

        if (! $this->validate($rules)) {
            return redirect()->back()->withInput()->with('error', 'Message is required.');
        }

        $post   = $this->request->getPost();
        $userId = auth()->id();

        $messageModel = new TicketMessageModel();
        $messageModel->insert([
            'ticket_id' => $post['ticket_id'],
            'user_id'   => $userId,
            'message'   => $post['message'],
        ]);

        // Determine user group
        $user   = auth()->user();
        $groups = $user->getGroups();

        $newStatus = in_array('user', $groups)
            ? 'customer replied'
            : 'awaiting customer';

        // Update ticket status
        $ticketModel = new TicketModel();
        $ticketModel->update($post['ticket_id'], [
            'status' => $newStatus,
        ]);

        return redirect()->to('/tickets/' . $post['ticket_id'])->with('message', 'Reply posted.');
    }
}
