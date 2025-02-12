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

            // Create roles
            DB::connection('mongodb')
                ->selectCollection('roles')
                ->updateOne(
                    ['name' => 'user', 'guard_name' => 'web'],
                    ['$set' => ['name' => 'user', 'guard_name' => 'web']],
                    ['upsert' => true]
                );

            DB::connection('mongodb')
                ->selectCollection('roles')
                ->updateOne(
                    ['name' => 'admin', 'guard_name' => 'web'],
                    ['$set' => ['name' => 'admin', 'guard_name' => 'web']],
                    ['upsert' => true]
                );

            // Assign permissions to roles
            $userPermissions = ['show_cctv', 'show_legend', 'show_poi'];
            DB::connection('mongodb')
                ->selectCollection('role_has_permissions')
                ->deleteMany(['role_name' => 'user']);
            
            foreach ($userPermissions as $permission) {
                DB::connection('mongodb')
                    ->selectCollection('role_has_permissions')
                    ->insertOne([
                        'role_name' => 'user',
                        'permission_name' => $permission
                    ]);
            }

            // Assign all permissions to admin
            DB::connection('mongodb')
                ->selectCollection('role_has_permissions')
                ->deleteMany(['role_name' => 'admin']);
            
            foreach ($permissions as $permission) {
                DB::connection('mongodb')
                    ->selectCollection('role_has_permissions')
                    ->insertOne([
                        'role_name' => 'admin',
                        'permission_name' => $permission
                    ]);
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
