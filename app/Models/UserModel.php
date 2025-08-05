<?php

namespace App\Models;

use CodeIgniter\Shield\Models\UserModel as ShieldUserModel;
use App\Entities\User; // Import your custom User entity

class UserModel extends ShieldUserModel
{
    protected $returnType = User::class; // Ensure it returns your custom User entity

    // You can add custom validation rules, allowed fields,
    // or override Shield's methods here if necessary.
    // For example, if you want to add a default profile creation
    // when a user is registered, you might override the insert() method.

    // protected $allowedFields = [
    //     // Default Shield allowed fields (uncomment and modify if you need to override)
    //     'username',
    //     'status',
    //     'status_message',
    //     'active',
    //     'last_active',
    //     'deleted_at',
    // ];

    protected $validationGroups = [
        'create' => [
            'username'         => 'required|alpha_numeric_space|min_length[3]|max_length[30]|is_unique[users.username]',
            'email'            => 'required|valid_email|is_unique[auth_identities.secret]',
            'group'            => 'required|string',
            'password'         => 'required|min_length[8]',
            'password_confirm' => 'required_with[password]|matches[password]',
        ],

        'update' => [
            'username'         => 'required|alpha_numeric_space|min_length[3]|max_length[30]',
            'email'            => 'required|valid_email',
            'group'            => 'required|string',
            'password'         => 'permit_empty|min_length[8]',
            'password_confirm' => 'required_with[password]|matches[password]',
        ],
    ];

    public function getValidationRulesByGroupName(string $groupName)
    {
        return $this->validationGroups[$groupName];
    }

    public function getUsersByGroupName(string $groupName)
    {
        return $this->builder()
            ->select('users.*') // Select all columns from the users table
            ->join('auth_groups_users', 'auth_groups_users.user_id = users.id')
            ->where('auth_groups_users.group', $groupName) // Correctly filters by the group name in the 'auth_groups' table
            ->get()
            ->getResult($this->returnType); // Ensure it returns your custom User entities
    }
}
