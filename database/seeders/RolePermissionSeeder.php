<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use Illuminate\Support\Facades\DB;

class RolePermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Reset cached roles and permissions
        app()[\Spatie\Permission\PermissionRegistrar::class]->forgetCachedPermissions();

        $permissions = [
            'show_notifikasi',
            'show_playback',
            'show_cctv',
            'is_controlled_ptz',
            'show_legend',
            'show_poi',
            'show_layer_map',
            'show_server_status',
            'show_report',
            'export_report',
            'show_user_management',
            'add_user',
            'delete_user',
            'edit_user',
        ];

        if (DB::getDriverName() == 'mongodb') {
            // Create permissions
            foreach ($permissions as $permission) {
                DB::connection('mongodb')
                    ->selectCollection('permissions')
                    ->updateOne(
                        ['name' => $permission, 'guard_name' => 'web'],
                        ['$set' => ['name' => $permission, 'guard_name' => 'web', 'updated_at' => now()]],
                        ['upsert' => true]
                    );
            }

            // Create roles with their permissions
            $roles = [
                'user' => ['show_cctv', 'show_legend', 'show_poi'],
                'admin' => $permissions
            ];

            foreach ($roles as $roleName => $rolePermissions) {
                // Create/Update role
                DB::connection('mongodb')
                    ->selectCollection('roles')
                    ->updateOne(
                        ['name' => $roleName, 'guard_name' => 'web'],
                        [
                            '$set' => [
                                'name' => $roleName,
                                'guard_name' => 'web',
                                'permissions' => array_map(function($permission) {
                                    return [
                                        'name' => $permission,
                                        'guard_name' => 'web'
                                    ];
                                }, $rolePermissions)
                            ]
                        ],
                        ['upsert' => true]
                    );
            }
        } else {
            if (config('database.default') === 'pgsql') {
                DB::statement("SELECT setval('permissions_id_seq', (SELECT COALESCE(MAX(id), 0) FROM permissions));");
            }

            foreach ($permissions as $permission) {
                Permission::updateOrCreate(
                    ['name' => $permission, 'guard_name' => 'web'],
                    ['updated_at' => now()]
                );
            }

            if (config('database.default') === 'pgsql') {
                DB::statement("SELECT setval('roles_id_seq', (SELECT COALESCE(MAX(id), 0) FROM roles));");
            }

            $userRole = Role::firstOrCreate(['name' => 'user']);
            $userRole->syncPermissions(['show_cctv', 'show_legend', 'show_poi']);

            $adminRole = Role::firstOrCreate(['name' => 'admin']);
            $adminRole->syncPermissions(Permission::all());
        }

        // Reset cached roles and permissions
        app()[\Spatie\Permission\PermissionRegistrar::class]->forgetCachedPermissions();
    }
}
