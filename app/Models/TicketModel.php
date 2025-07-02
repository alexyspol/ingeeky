<?php

namespace App\Models;

use CodeIgniter\Model;

class TicketModel extends Model
{
    protected $table      = 'tickets';
    protected $primaryKey = 'id';

    protected $allowedFields = ['title', 'status', 'created_by'];

    protected $useTimestamps = true;
    protected $dateFormat    = 'datetime';

    protected $validationRules = [
        'title'      => 'required|min_length[3]|max_length[255]',
        'status'     => 'required|in_list[open,closed,pending]',
        'created_by' => 'required|integer',
    ];

    protected $validationMessages = [
        'title' => [
            'required'   => 'A title is required.',
            'min_length' => 'Title must be at least 3 characters.',
        ],
        'status' => [
            'required' => 'Please select a status.',
            'in_list'  => 'Status must be one of: open, closed, pending.',
        ],
    ];
}
