<?php namespace App\Controllers;

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
        return view('users/index', $data);
    }

    public function new()
    {
        return view('users/new', $this->getGroupData());
    }

    public function create()
    {
        $db = \Config\Database::connect();
        $db->transStart();

        if (! $this->userModel->validate('create')) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        $user = new User($this->getPostedUserData());

        if (! $this->userModel->save($user, 'create')) {
            $db->transRollback();
            return redirect()->back()->withInput()->with('errors', $this->userModel->errors());
        }

        try {
            // Re-fetch the user to ensure ID is present
            $user = $this->userModel->findByCredentials(['email' => $user->email]);

            $user->syncGroups($this->request->getPost('group'));
            $this->userModel->save($user, 'update');

            $db->transComplete();

            if ($db->transStatus() === false) {
                throw new \Exception('Transaction failed');
            }

            return redirect()->to(route_to('users.index'))->with('message', 'User created successfully.');
        } catch (\Throwable $e) {
            $db->transRollback();
            return redirect()->back()->withInput()->with('errors', ['transaction' => $e->getMessage()]);
        }
    }

    public function edit($id)
    {
        helper('form');

        $user = $this->userModel->findById($id);

        if (! $user) {
            throw PageNotFoundException::forPageNotFound('User not found.');
        }

        $data = $this->getGroupData();
        $data['user'] = $user;
        $data['userGroups'] = $user->getGroups();

        return view('users/edit', $data);
    }

    public function update($userId)
    {
        $user = $this->userModel->find($userId);

        if (! $user) {
            throw PageNotFoundException::forPageNotFound('User not found.');
        }

        $rules = $this->userModel->getValidationRulesByGroupName('update');
        $rules['username'] .= "|is_unique[users.username,id,$userId]";
        $rules['email']    .= "|is_unique[auth_identities.secret,user_id,$userId]";

        if (!$this->validate($rules)) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        $userData = $this->getPostedUserData();

        $user->fill($userData);
        $user->syncGroups($this->request->getPost('group'));

        if (! $this->userModel->save($user)) {
            return redirect()->back()->withInput()->with('errors', $this->userModel->errors());
        }

        return redirect()->to(route_to('users.index'))->with('message', 'User updated successfully.');
    }

    public function delete($userId)
    {
        if (! $this->userModel->delete($userId, true)) {
            return redirect()->back()->with('error', 'Failed to delete user.');
        }

        return redirect()->to(route_to('users.index'))->with('message', 'User deleted successfully.');
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

    protected function getPostedUserData()
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
}
