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
        'department',
    ];

    protected $useTimestamps = true;
    protected $dateFormat    = 'datetime';

    protected $validationGroups = [
        // Note:
        //  - the 'in_list' rule for 'department' is added dynamically.
        'update' => [
            'title'       => 'permit_empty|min_length[3]|max_length[255]',
            'status'      => 'permit_empty|in_list[open,customer replied,awaiting customer,closed]',
            'priority'    => 'permit_empty|in_list[low,normal,high]',
            'customer_id' => 'permit_empty|integer|is_not_unique[users.id]',
            'department'  => 'required',
        ],

        // Note:
        //  - 'status' and 'created_by' are set in the controller,
        //  - the 'in_list' rule for 'department' is added dynamically.
        'create' => [
            'title'       => 'required|min_length[3]|max_length[255]',
            'priority'    => 'required|in_list[low,normal,high]',
            'customer_id' => 'required|integer|is_not_unique[users.id]',
            'department'  => 'required',
            'message'     => 'required',
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
        'department' => [
            'required' => 'Please select a department.',
            'in_list'  => 'Please select a valid department from the provided list.',
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

    public function getValidationRulesByGroupName(string $groupName)
    {
        return $this->validationGroups[$groupName];
    }
}