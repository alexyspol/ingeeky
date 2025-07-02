<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;
use CodeIgniter\Shield\Entities\User;

class UsersSeeder extends Seeder
{
    public function run()
    {
        $users = auth()->getProvider();

        $userList = [
            [
                'username' => 'admin',
                'email'    => 'admin@ingeeky.com',
                'group'    => 'admin',
            ],
            [
                'username' => 'testuser',
                'email'    => 'user@ingeeky.com',
                'group'    => 'user',
            ],
            [
                'username' => 'support',
                'email'    => 'support@ingeeky.com',
                'group'    => 'support',
            ],
        ];

        foreach ($userList as $data) {
            $user = new User([
                'username' => $data['username'],
                'email'    => $data['email'],
                'password' => 'password',
            ]);

            $users->save($user);
            $savedUser = $users->findById($users->getInsertID());
            $savedUser->addGroup($data['group']);

            echo "User created: {$data['email']} (group: {$data['group']}, password: password)\n";
        }
    }
}
