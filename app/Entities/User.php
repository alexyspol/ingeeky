<?php

namespace App\Entities;

use CodeIgniter\Shield\Entities\User as ShieldUser;
use App\Models\ProfileModel; // Import your ProfileModel
use App\Entities\Profile;    // Import your Profile entity

class User extends ShieldUser
{
    /**
     * Cache for the user's profile.
     *
     * @var Profile|null
     */
    private $profileCache;

    /**
     * Get the user's associated profile.
     *
     * @return Profile|null
     */
    public function getProfile(): ?Profile
    {
        // If the profile is already loaded, return it from cache.
        if ($this->profileCache !== null) {
            return $this->profileCache;
        }

        // Load the ProfileModel
        $profileModel = model(ProfileModel::class);

        // Find the profile associated with this user's ID
        $profile = $profileModel->where('user_id', $this->id)->first();

        // If no profile exists, create a new empty one linked to this user
        // This ensures you always have a Profile object to work with, even if empty.
        if ($profile === null) {
            $profile = new Profile([
                'user_id' => $this->id,
            ]);
        }

        // Cache the profile for future access during the same request
        $this->profileCache = $profile;

        return $this->profileCache;
    }
}
