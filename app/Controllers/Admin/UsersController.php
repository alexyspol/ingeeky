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
        return view('admin/users/new', $this->getGroupData());
    }

    public function create()
    {
        $rules = $this->getValidationRules('create');

        if (! $this->validate($rules)) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        $user = new User($this->getPostedUserData());

        if (! $this->userModel->save($user)) {
            return redirect()->back()->withInput()->with('errors', $this->userModel->errors());
        }

        // Re-fetch the user to ensure ID is present
        $user = $this->userModel->findByCredentials(['email' => $user->email]);

        $this->assignGroupToUser($user, $this->request->getPost('group'));

        return redirect()->to(route_to('admin.users.index'))->with('message', 'User created successfully.');
    }

    public function edit($id)
    {
        $user = $this->userModel->findById($id);

        if (! $user) {
            throw PageNotFoundException::forPageNotFound('User not found.');
        }

        $data = $this->getGroupData();
        $data['user'] = $user;
        $data['userGroups'] = $user->getGroups();

        return view('admin/users/edit', $data);
    }

    public function update($id)
    {
        $user = $this->userModel->findById($id);

        if (! $user) {
            throw PageNotFoundException::forPageNotFound('User not found.');
        }

        $rules = $this->getValidationRules('update', $id);

        if (! $this->validate($rules)) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        $user->fill($this->getPostedUserData(true));

        if (! $this->userModel->save($user)) {
            return redirect()->back()->withInput()->with('errors', $this->userModel->errors());
        }

        $this->assignGroupToUser($user, $this->request->getPost('group'));

        return redirect()->to(route_to('admin.users.index'))->with('message', 'User updated successfully.');
    }

    public function delete($id)
    {
        if (! $this->userModel->delete($id, true)) {
            return redirect()->back()->with('error', 'Failed to delete user.');
        }

        return redirect()->to(route_to('admin.users.index'))->with('message', 'User deleted successfully.');
    }

    // ---------------------
    // 🔧 Helper Methods
    // ---------------------

    protected function getGroupData(): array
    {
        $config = config('AuthGroups');
        $allGroups = array_keys($config->groups);
        sort($allGroups);

        return [
            'allGroups'    => $allGroups,
            'defaultGroup' => $config->defaultGroup,
        ];
    }

    protected function getValidationRules(string $context, ?int $userId = null): array
    {
        $rules = [
            'username' => "required|alpha_numeric_space|min_length[3]|max_length[30]|is_unique[users.username" . ($userId ? ",id,$userId" : "") . "]",
            'email'    => "required|valid_email|is_unique[auth_identities.secret" . ($userId ? ",user_id,$userId" : "") . "]",
            'group'    => 'required|string',
        ];

        if ($context === 'create' || $this->request->getPost('password')) {
            $rules['password'] = 'required|min_length[8]';
            $rules['password_confirm'] = 'required_with[password]|matches[password]';
        }

        return $rules;
    }

    protected function getPostedUserData(bool $isUpdate = false): array
    {
        $data = [
            'username' => $this->request->getPost('username'),
            'email'    => $this->request->getPost('email'),
        ];

        $password = $this->request->getPost('password');
        if (!empty($password)) {
            $data['password'] = $password;
        }

        return $data;
    }

    protected function assignGroupToUser(User $user, string $group)
    {
        if ($user->id) {
            $user->syncGroups($group);
            $this->userModel->save($user); // persist group assignment
        }
    }
}
