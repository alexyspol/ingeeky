<?php

namespace App\Controllers;

use App\Models\TicketMessageModel;

class TicketMessagesController extends \App\Controllers\BaseController
{
    public function create()
    {
        $post = $this->request->getPost();

        // Basic validation (optional: use $this->validate instead)
        if (empty($post['ticket_id']) || empty($post['message'])) {
            return redirect()->back()->withInput()->with('error', 'Message is required.');
        }

        $userId = auth()->id();

        $messageModel = new TicketMessageModel();
        $messageModel->insert([
            'ticket_id' => $post['ticket_id'],
            'user_id'   => $userId,
            'message'   => $post['message'],
        ]);

        return redirect()->to('/tickets/' . $post['ticket_id'])->with('message', 'Reply posted.');
    }
}
