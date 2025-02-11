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

        // Create permissions (ONLY ONCE)
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

        if (config('database.default') === 'pgsql') {
            // Ensure the sequence is set correctly after all inserts
            DB::statement("SELECT setval('permissions_id_seq', (SELECT COALESCE(MAX(id), 0) FROM permissions));");
        }

        foreach ($permissions as $permission) {
            // Use updateOrCreate to avoid unique constraint violation
            Permission::updateOrCreate(
                ['name' => $permission, 'guard_name' => 'web'],
                ['updated_at' => now()]
            );
        }

        if (config('database.default') === 'pgsql') {
            // Ensure the sequence is set correctly after all inserts
            DB::statement("SELECT setval('roles_id_seq', (SELECT COALESCE(MAX(id), 0) FROM roles));");
        }

        // Create roles and assign permissions
        $userRole = Role::firstOrCreate(['name' => 'user']);
        $userRole->syncPermissions(['show_cctv', 'show_legend', 'show_poi']);

        $adminRole = Role::firstOrCreate(['name' => 'admin']);
        $adminRole->syncPermissions(Permission::all());

        // Reset cached roles and permissions (again, after roles are created)
        app()[\Spatie\Permission\PermissionRegistrar::class]->forgetCachedPermissions();
    }
}
