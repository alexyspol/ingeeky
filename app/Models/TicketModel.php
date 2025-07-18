<?php

namespace App\Models;

use CodeIgniter\Model;

class TicketModel extends Model
{
    protected $table         = 'tickets';
    protected $primaryKey    = 'id';

    // Add 'customer_id' to allowed fields
    protected $allowedFields = ['title', 'status', 'created_by', 'customer_id', 'product_id']; // Added product_id as well as it's in your migration

    protected $useTimestamps = true;
    protected $dateFormat    = 'datetime';

    protected $validationRules = [
        'title'      => 'required|min_length[3]|max_length[255]',
        'status'     => 'required|in_list[open,closed,pending,customer replied,awaiting customer]',
        'created_by' => 'required|integer',
        // Add validation for customer_id. For customers, this will be auto-filled by their ID.
        // For admins, it might be required or null depending on your exact business logic.
        // For now, let's assume it's an integer if provided.
        'customer_id' => 'permit_empty|integer', // 'permit_empty' allows it to be null or empty string, which is useful when not directly supplied by customer
    ];

    protected $validationMessages = [
        'title' => [
            'required'   => 'A title is required.',
            'min_length' => 'Title must be at least 3 characters.',
        ],
        'status' => [
            'required' => 'Please select a status.',
            'in_list'  => 'Status must be one of: open, closed, customer replied, awaiting customer.', // Updated list based on your migration
        ],
        'customer_id' => [
            'integer' => 'Customer ID must be an integer.',
        ],
    ];
}