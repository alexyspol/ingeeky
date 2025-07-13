<?php namespace App\Controllers\Admin;

use CodeIgniter\Exceptions\PageNotFoundException;
use App\Controllers\BaseController;
use App\Entities\User;

class UsersController extends BaseController
{
    protected $userModel;

    public function __construct()
    {
        $this->userModel = auth()->getProvider();
    }

    public function index()
    {
        $data['users'] = $this->userModel->findAll();
        return view('admin/users/index', $data);
    }

    public function new()
    {
        $authGroupsConfig = config('AuthGroups');
        $allGroupDefinitions = $authGroupsConfig->groups;
        $data['allGroups'] = array_keys($allGroupDefinitions);
        sort($data['allGroups']);

        $data['defaultGroup'] = $authGroupsConfig->defaultGroup;

        return view('admin/users/new', $data);
    }

    public function create()
    {
        $rules = [
            'username'         => 'required|alpha_numeric_space|min_length[3]|max_length[30]|is_unique[users.username]',
            'email'            => 'required|valid_email|is_unique[auth_identities.secret]',
            'password'         => 'required|min_length[8]',
            'password_confirm' => 'required_with[password]|matches[password]',
            'group'            => 'required|string',
        ];

        if (! $this->validate($rules)) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        $user = new User([
            'username' => $this->request->getPost('username'),
            'email'    => $this->request->getPost('email'),
            'password' => $this->request->getPost('password'),
        ]);

        if (! $this->userModel->save($user)) {
            return redirect()->back()->withInput()->with('errors', $this->userModel->errors());
        }

        $userIdentifier = $this->request->getPost('email');

        // Re-fetch the user from the database to ensure the ID is populated
        $user = $this->userModel->findByCredentials(['email' => $userIdentifier]);

        // Assign the user to the selected group
        $selectedGroup = $this->request->getPost('group');
        $user->addGroup($selectedGroup);
        $this->userModel->save($user);

        return redirect()->to(route_to('admin.users.index'))->with('message', 'User created successfully.');
    }

    public function edit($id)
    {
        $user = $this->userModel->findById($id);

        if (! $user) {
            throw PageNotFoundException::forPageNotFound('User not found.');
        }

        $data['user'] = $user;

        // Get all group definitions from app/Config/AuthGroups.php
        $authGroupsConfig = config('AuthGroups');
        $allGroupDefinitions = $authGroupsConfig->groups;

        // Extract just the group names (keys) for the dropdown
        $data['allGroups'] = array_keys($allGroupDefinitions);
        sort($data['allGroups']);

        // Get the groups the user currently belongs to (returns an array of group names)
        $data['userGroups'] = $user->getGroups();

        return view('admin/users/edit', $data);
    }

    public function update($id)
    {
        $user = $this->userModel->findById($id);

        if (! $user) {
            throw PageNotFoundException::forPageNotFound('User not found.');
        }

        $rules = [
            'username' => 'required|alpha_numeric_space|min_length[3]|max_length[30]|is_unique[users.username,id,' . $id . ']',
            'email'    => 'required|valid_email|is_unique[auth_identities.secret,user_id,' . $id . ']',
            'group'    => 'required|string',
        ];

        // Only validate password if it's being changed
        if ($this->request->getPost('password')) {
            $rules['password'] = 'min_length[8]';
            $rules['password_confirm'] = 'required_with[password]|matches[password]';
        }

        if (! $this->validate($rules)) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        $updateData = [
            'username' => $this->request->getPost('username'),
            'email'    => $this->request->getPost('email'),
        ];

        if ($this->request->getPost('password')) {
            $updateData['password'] = $this->request->getPost('password');
        }

        $user->fill($updateData);

        if (! $this->userModel->save($user)) {
            return redirect()->back()->withInput()->with('errors', $this->userModel->errors());
        }

        $selectedGroup = $this->request->getPost('group');
        if (! empty($selectedGroup)) {
            // syncGroups ensures the user only belongs to the groups provided in the array
            $user->syncGroups($selectedGroup);
            $this->userModel->save($user); // Save again to persist group changes
        }

        return redirect()->to(route_to('admin.users.index'))->with('message', 'User updated successfully.');
    }

    public function delete($id)
    {
        if (! $this->userModel->delete($id, true)) { // Pass true for permanent delete
            return redirect()->back()->with('error', 'Failed to delete user.');
        }

        return redirect()->to(route_to('admin.users.index'))->with('message', 'User deleted successfully.');
    }
}
