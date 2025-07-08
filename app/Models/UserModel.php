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

    // protected $validationRules = [
    //     // Default Shield validation rules (uncomment and modify if you need to override)
    //     'username' => 'required|alpha_numeric_space|min_length[3]|max_length[30]|is_unique[users.username,id,{id}]',
    //     'email'    => 'required|valid_email|is_unique[auth_identities.secret,id,{id}]',
    // ];
}
