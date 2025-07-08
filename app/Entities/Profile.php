<?php

namespace App\Entities;

use CodeIgniter\Entity\Entity;

/**
 * Represents a user profile with additional details like first name, last name, and phone.
 */
class Profile extends Entity
{
    // Define the properties that correspond to your 'profiles' table columns.
    // These are protected properties, accessible via magic methods __get() and __set().
    protected $attributes = [
        'id'         => null,
        'user_id'    => null,
        'first_name' => null,
        'last_name'  => null,
        'phone'      => null,
        'created_at' => null,
        'updated_at' => null,
        'deleted_at' => null,
    ];

    // Define mutators (setters) if you need to modify data before saving.
    // Example: public function setFirstName(string $name) { $this->attributes['first_name'] = ucwords($name); }

    // Define accessors (getters) if you need to format data when retrieving.
    // Example: public function getFullName() { return $this->attributes['first_name'] . ' ' . $this->attributes['last_name']; }
}
