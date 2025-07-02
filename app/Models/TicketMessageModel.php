<?php

namespace App\Models;

use CodeIgniter\Model;

class TicketMessageModel extends Model
{
    protected $table      = 'ticket_messages';
    protected $primaryKey = 'id';

    protected $allowedFields = ['ticket_id', 'user_id', 'message'];

    protected $useTimestamps = true;
    protected $createdField  = 'created_at';
    protected $updatedField  = ''; // No updated_at

    protected $validationRules = [
        'ticket_id' => 'required|integer',
        'user_id'   => 'required|integer',
        'message'   => 'required|string',
    ];

    protected $validationMessages = [
        'message' => [
            'required' => 'Message content is required.',
        ],
    ];
}
