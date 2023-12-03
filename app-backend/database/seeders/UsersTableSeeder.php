<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

class UsersTableSeeder extends Seeder
{
    public function run()
    {
        $users = [
            [
                'name' => 'user1',
                'username' => 'userA',
                'email' => 'user1@mail.com',
                'password' => Hash::make('password1'),
            ],
            [
                'name' => 'user2',
                'username' => 'userB',
                'email' => 'user2@mail.com',
                'password' => Hash::make('password2'),
            ],
        ];

        foreach ($users as $user) {
            User::create($user);
        }
    }
}
