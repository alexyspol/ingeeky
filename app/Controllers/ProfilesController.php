<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use CodeIgniter\HTTP\ResponseInterface;
use App\Models\ProfileModel;
use App\Entities\Profile;

class ProfilesController extends BaseController
{
    /**
     * @var ProfileModel
     */
    protected $profileModel;

    public function __construct()
    {
        $this->profileModel = new ProfileModel();
    }

    /**
     * Displays the user profile editing form.
     *
     * @return ResponseInterface|string
     */
    public function edit()
    {
        // Get the currently authenticated user
        $user = auth()->user();

        // If no user is logged in, redirect them (or show an error)
        if (! $user) {
            return redirect()->to(route_to('login'))->with('error', 'You must be logged in to view your profile.');
        }

        // Get the user's profile using the custom getProfile() method from the User entity
        $profile = $user->getProfile();

        // Pass the profile data to the view
        $data = [
            'profile' => $profile,
            'validation' => \Config\Services::validation(), // For displaying validation errors
        ];

        return view('profile/edit', $data);
    }

    /**
     * Handles the submission of the profile editing form.
     *
     * @return ResponseInterface
     */
    public function update()
    {
        // Get the currently authenticated user
        $user = auth()->user();

        // Get the user's profile (this will create a new empty one if it doesn't exist)
        $profile = $user->getProfile();

        // Set the rules for validation
        $rules = [
            'first_name' => 'permit_empty|max_length[100]',
            'last_name'  => 'permit_empty|max_length[100]',
            'phone'      => 'permit_empty|max_length[20]|numeric',
        ];

        // Validate the incoming request data
        if (! $this->validate($rules)) {
            // If validation fails, redirect back with input and errors
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        // Prepare data for updating the profile entity
        $profile->fill($this->request->getPost([
            'first_name',
            'last_name',
            'phone',
        ]));

        // Ensure user_id is set if it's a new profile
        if (empty($profile->user_id)) {
            $profile->user_id = $user->id;
        }

        // Save the profile data
        // If the profile ID is null, it means it's a new profile, so insert it.
        // Otherwise, update the existing profile.
        if ($profile->id === null) {
            // This will insert a new record and update the $profile entity with the new ID
            if (! $this->profileModel->save($profile)) {
                return redirect()->back()->withInput()->with('errors', $this->profileModel->errors());
            }
        } else {
            // This will update an existing record
            if (! $this->profileModel->save($profile)) {
                return redirect()->back()->withInput()->with('errors', $this->profileModel->errors());
            }
        }

        return redirect()->to(route_to('profile.edit'))->with('message', 'Profile updated successfully!');
    }
}
