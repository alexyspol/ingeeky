<?php namespace App\Controllers\Admin;

use CodeIgniter\Exceptions\PageNotFoundException;
use App\Controllers\BaseController;
use App\Entities\User;

class UserController extends BaseController
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
        return view('admin/users/new');
    }

    public function create()
    {
        $rules = [
            'username' => 'required|alpha_numeric_space|min_length[3]|max_length[30]|is_unique[users.username]',
            'email'    => 'required|valid_email|is_unique[auth_identities.secret]', // Shield stores email in auth_identities.secret
            'password' => 'required|min_length[8]',
            'password_confirm' => 'required_with[password]|matches[password]',
            // Add validation for custom fields here
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

        // Handle custom fields if you have a separate user_details table
        // $userDetailsModel = new App\Models\UserDetailsModel();
        // $userDetailsData = [
        //     'user_id' => $user->id,
        //     'first_name' => $this->request->getPost('first_name'),
        //     'last_name' => $this->request->getPost('last_name'),
        // ];
        // $userDetailsModel->insert($userDetailsData);

        return redirect()->to(route_to('admin.users.index'))->with('message', 'User created successfully.');
    }

    public function edit($id)
    {
        $user = $this->userModel->findById($id);

        if (! $user) {
            throw PageNotFoundException::forPageNotFound('User not found.');
        }

        $data['user'] = $user;
        // Load custom user details if applicable
        // $data['userDetails'] = (new App\Models\UserDetailsModel())->where('user_id', $id)->first();

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
            // Add validation for custom fields
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

        // Update custom fields if you have a separate user_details table
        // $userDetailsModel = new App\Models\UserDetailsModel();
        // $userDetailsData = [
        //     'first_name' => $this->request->getPost('first_name'),
        //     'last_name' => $this->request->getPost('last_name'),
        // ];
        // $userDetailsModel->update($user->id, $userDetailsData); // Assuming user_id is the primary key for update

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
