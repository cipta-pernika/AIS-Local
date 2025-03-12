<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;

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

        if (DB::getDriverName() == 'mongodb') {
            foreach ($users as $user) {
                DB::connection('mongodb')
                    ->selectCollection('users')
                    ->insertOne($user);
            }
        } else {
            foreach ($users as $user) {
                User::create($user);
            }
        }
    }
}
