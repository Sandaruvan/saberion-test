<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class UsersSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $users = [
            [
                'name' => 'Admin',
                'email' => 'admin@admin.com',
                'password' => bcrypt('admin@123'),
                'user_role' => 'admin',
            ],
            [
                'name' => 'Moderator',
                'email' => 'moderator@admin.com',
                'password' => bcrypt('moderator@123'),
                'user_role' => 'moderator',
            ],
            [
                'name' => 'Test User',
                'email' => 'user@admin.com',
                'password' => bcrypt('user@123'),
                'user_role' => 'user',
            ]
        ];

        foreach ($users as $user) {
            User::updateOrCreate(
                [
                    'email' => $user['email']
                ],
                [
                    'name' => $user['name'],
                    'email' => $user['email'],
                    'password' => $user['password'],
                    'user_role' => $user['user_role'],
                ]
            );
        }
    }
}
