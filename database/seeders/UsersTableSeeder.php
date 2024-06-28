<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Faker\Factory as Faker;
use Illuminate\Support\Facades\Artisan;

class UsersTableSeeder extends Seeder
{
    public function run()
    {
        $faker = Faker::create();

        // Superadmin user
        $sid = Str::uuid();
        DB::table('users')->insert([
            'id' => $sid,
            'username' => 'superadmin',
            'firstname' => 'Super',
            'lastname' => 'Admin',
            'email' => 'superadmin@database.com',
            'email_verified_at' => now(),
            'password' => Hash::make('123456'),
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        // Bind superadmin user to FilamentShield
        Artisan::call('shield:super-admin', ['--user' => $sid]);

        $userId = Str::uuid();
        DB::table('users')->insert([
            'id' => $userId,
            'username' => 'admin',
            'firstname' => 'Admin',
            'lastname' => $faker->lastName,
            'email' => 'admin@database.com',
            'email_verified_at' => now(),
            'password' => Hash::make('123456'),
            'created_at' => now(),
            'updated_at' => now(),
        ]);
        DB::table('model_has_roles')->insert([
            'role_id' => 2,
            'model_type' => 'App\Models\User',
            'model_id' => $userId,
        ]);

        $userId = Str::uuid();
        DB::table('users')->insert([
            'id' => $userId,
            'username' => 'operator',
            'firstname' => 'Operator',
            'lastname' => $faker->lastName,
            'email' => 'operator@database.com',
            'email_verified_at' => now(),
            'password' => Hash::make('123456'),
            'created_at' => now(),
            'updated_at' => now(),
        ]);
        DB::table('model_has_roles')->insert([
            'role_id' => 3,
            'model_type' => 'App\Models\User',
            'model_id' => $userId,
        ]);

        $userId = Str::uuid();
        DB::table('users')->insert([
            'id' => $userId,
            'username' => 'operatorimpt',
            'firstname' => 'Operator IMPT',
            'lastname' => $faker->lastName,
            'email' => 'operatorimpt@database.com',
            'email_verified_at' => now(),
            'password' => Hash::make('123456'),
            'created_at' => now(),
            'updated_at' => now(),
        ]);
        DB::table('model_has_roles')->insert([
            'role_id' => 4,
            'model_type' => 'App\Models\User',
            'model_id' => $userId,
        ]);

        $userId = Str::uuid();
        DB::table('users')->insert([
            'id' => $userId,
            'username' => 'operatorpbkm',
            'firstname' => 'Operator PBKM',
            'lastname' => $faker->lastName,
            'email' => 'operatorpbkm@database.com',
            'email_verified_at' => now(),
            'password' => Hash::make('123456'),
            'created_at' => now(),
            'updated_at' => now(),
        ]);
        DB::table('model_has_roles')->insert([
            'role_id' => 5,
            'model_type' => 'App\Models\User',
            'model_id' => $userId,
        ]);

        $userId = Str::uuid();
        DB::table('users')->insert([
            'id' => $userId,
            'username' => 'operatorpelindo',
            'firstname' => 'Operator Pelindo',
            'lastname' => $faker->lastName,
            'email' => 'operatorpelindo@database.com',
            'email_verified_at' => now(),
            'password' => Hash::make('123456'),
            'created_at' => now(),
            'updated_at' => now(),
        ]);
        DB::table('model_has_roles')->insert([
            'role_id' => 6,
            'model_type' => 'App\Models\User',
            'model_id' => $userId,
        ]);

        // $roles = DB::table('roles')->whereNot('name', 'super_admin')->get();
        // foreach ($roles as $role) {
        //     for ($i = 0; $i < 10; $i++) {
        //         $userId = Str::uuid();
        //         DB::table('users')->insert([
        //             'id' => $userId,
        //             'username' => $faker->unique()->userName,
        //             'firstname' => $faker->firstName,
        //             'lastname' => $faker->lastName,
        //             'email' => $faker->unique()->safeEmail,
        //             'email_verified_at' => now(),
        //             'password' => Hash::make('password'),
        //             'created_at' => now(),
        //             'updated_at' => now(),
        //         ]);
        //         DB::table('model_has_roles')->insert([
        //             'role_id' => $role->id,
        //             'model_type' => 'App\Models\User',
        //             'model_id' => $userId,
        //         ]);
        //     }
        // }
    }
}
