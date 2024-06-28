<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Artisan;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class RolesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $roles = ["super_admin", "admin", "operator", "operatorimpt", "operatorpbkm", "operatorpelindo"];

        foreach ($roles as $key => $role) {
            DB::table('roles')->insert(
                [
                    'name' => $role,
                    'guard_name' => 'web',
                    'created_at' => now(),
                    'updated_at' => now(),
                ]
            );
        }

        Artisan::call('shield:generate --all');

        $role = Role::find(2);
        $role->givePermissionTo(Permission::all());

        $role = Role::find(3);
        $includedPermission = ['Impt', 'Inaportnet', 'Pbkm', 'Pelindo'];
        $permissions = Permission::where(function ($query) use ($includedPermission) {
            foreach ($includedPermission as $value) {
                $query->orWhere('name', 'like', '%' . $value . '%');
            }
        })->pluck('name')->toArray();
        $role->givePermissionTo($permissions);

        $role = Role::find(4);
        $includedPermission = ['Impt', 'Inaportnet'];
        $permissions = Permission::where(function ($query) use ($includedPermission) {
            foreach ($includedPermission as $value) {
                $query->orWhere('name', 'like', '%' . $value . '%');
            }
        })->pluck('name')->toArray();
        $role->givePermissionTo($permissions);

        $role = Role::find(5);
        $includedPermission = ['Pbkm', 'Inaportnet'];
        $permissions = Permission::where(function ($query) use ($includedPermission) {
            foreach ($includedPermission as $value) {
                $query->orWhere('name', 'like', '%' . $value . '%');
            }
        })->pluck('name')->toArray();
        $role->givePermissionTo($permissions);

        $role = Role::find(6);
        $includedPermission = ['Pelindo', 'Inaportnet'];
        $permissions = Permission::where(function ($query) use ($includedPermission) {
            foreach ($includedPermission as $value) {
                $query->orWhere('name', 'like', '%' . $value . '%');
            }
        })->pluck('name')->toArray();
        $role->givePermissionTo($permissions);
    }
}
