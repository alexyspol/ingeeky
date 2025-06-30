<?php

namespace App\Models;

use CodeIgniter\Model;

class TicketModel extends Model
{
    protected $table      = 'tickets';
    protected $primaryKey = 'id';

    protected $allowedFields = ['title', 'description', 'status', 'created_at', 'updated_at'];

    // Optional: Automatically handle created_at and updated_at timestamps
    protected $useTimestamps = true;

    // Optional: Specify date format
    protected $dateFormat = 'datetime';

    // Optional: Validation rules
    protected $validationRules = [
        'title'       => 'required|min_length[3]|max_length[255]',
        'description' => 'required',
        'status'      => 'required|in_list[open,closed,pending]',
    ];

    protected $validationMessages = [
        'title' => [
            'required'   => 'A title is required.',
            'min_length' => 'Title must be at least 3 characters.',
        ],
        'description' => [
            'required' => 'Please provide a description.',
        ],
        'status' => [
            'required' => 'Please select a status.',
            'in_list'  => 'Status must be one of: open, closed, pending.',
        ],
    ];
}
