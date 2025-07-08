<?php

namespace App\Models;

use CodeIgniter\Model;
use App\Entities\Profile; // Import the Profile entity

/**
 * Model for the 'profiles' table.
 * Handles all database interactions for user profiles.
 */
class ProfileModel extends Model
{
    protected $table         = 'profiles';
    protected $primaryKey    = 'id';
    protected $useAutoIncrement = true;

    // This is crucial. It tells the model to return instances of your Profile entity.
    protected $returnType    = Profile::class; // Use ::class for better practice

    // This enables the use of 'deleted_at' for soft deletes.
    protected $useSoftDeletes = true;

    // These are the fields that are allowed to be saved to the database.
    protected $allowedFields = ['user_id', 'first_name', 'last_name', 'phone'];

    // Automatically handle created_at and updated_at timestamps.
    protected $useTimestamps = true;
    protected $dateFormat    = 'datetime';
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';
    protected $deletedField  = 'deleted_at';

    // You can add validation rules here if needed.
    protected $validationRules      = [
        'first_name' => 'permit_empty|max_length[100]',
        'last_name'  => 'permit_empty|max_length[100]',
        'phone'      => 'permit_empty|max_length[20]|numeric', // Basic phone validation
    ];
    protected $validationMessages   = [];
    protected $skipValidation       = false;
    protected $cleanValidationRules = true;
}
