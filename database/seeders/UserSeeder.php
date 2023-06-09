<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $users = [
            [
                'name' => 'John Doe',
                'email' => 'admin@database.com',
                'password' => Hash::make('123456'),
            ],
            [
                'name' => 'Jane Smith',
                'email' => 'superadmin@database.com',
                'password' => Hash::make('123456'),
            ],
        ];

        foreach ($users as $user) {
            User::create($user);
        }
    }
}
