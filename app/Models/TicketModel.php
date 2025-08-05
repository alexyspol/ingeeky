<?php

namespace App\Models;

use CodeIgniter\Model;

class TicketModel extends Model
{
    protected $table         = 'tickets';
    protected $primaryKey    = 'id';

    protected $allowedFields = [
        'title',
        'status',
        'created_by',
        'customer_id',
        'priority',
    ];

    protected $useTimestamps = true;
    protected $dateFormat    = 'datetime';

    protected $validationRules = [
    // These are the rules for a CREATE action
        'title'       => 'required|min_length[3]|max_length[255]',
        'status'      => 'required|in_list[open,closed,pending,customer replied,awaiting customer]',
        'created_by'  => 'required|integer|is_not_unique[users.id]',
        'customer_id' => 'required|integer|is_not_unique[users.id]',
        'priority'    => 'required|in_list[low,normal,high]',
    ];

    protected $validationGroups = [
        // This is a group of rules for an UPDATE action
        'update' => [
            'title'       => 'permit_empty|min_length[3]|max_length[255]',
            'status'      => 'permit_empty|in_list[open,customer replied,awaiting customer,closed]',
            'priority'    => 'permit_empty|in_list[low,normal,high]',
            'customer_id' => 'permit_empty|integer|is_not_unique[users.id]',
        ],
        // The default rules can also be put in a group
        'create' => [
            'title'       => 'required|min_length[3]|max_length[255]',
            'status'      => 'required|in_list[open,customer replied,awaiting customer,closed]',
            'priority'    => 'required|in_list[low,normal,high]',
            'customer_id' => 'required|integer|is_not_unique[users.id]',
            'created_by'  => 'required|integer|is_not_unique[users.id]',
        ],
    ];

    protected $validationMessages = [
        'title' => [
            'required'   => 'A title is required.',
            'min_length' => 'Title must be at least 3 characters.',
        ],
        'status' => [
            'required' => 'Please select a status.',
            'in_list'  => 'Status must be one of: open, closed, customer replied, awaiting customer.',
        ],
        'priority' => [
            'required' => 'Please select a priority.',
            'in_list'  => 'Priority must be one of: low, normal, high.',
        ],
        'customer_id' => [
            'required'      => 'Customer is required.',
            'integer'       => 'Customer ID must be an integer.',
            'is_not_unique' => 'Selected customer does not exist.',
        ],
        'created_by' => [
            'required'      => 'Creator is required.',
            'integer'       => 'Creator ID must be an integer.',
            'is_not_unique' => 'Creator user does not exist.',
        ],
    ];

    public function getAllowedFields()
    {
        return $this->allowedFields;
    }
}