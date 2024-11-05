<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class RolesAndPermissionsSeeder extends Seeder
{
    public function run(): void
    {
        // Reset cached roles and permissions
        app()[\Spatie\Permission\PermissionRegistrar::class]->forgetCachedPermissions();

        // Create permissions
        $permissions = [
            // Notifikasi
            'show_notifikasi',
            
            // Playback
            'show_playback',
            
            // Kamera
            'show_cctv',
            'is_controlled_ptz',
            
            // Legend
            'show_legend',
            
            // POI
            'show_poi',
            
            // Jenis Map
            'show_layer_map',
            
            // Server Status
            'show_server_status',
            
            // Report
            'show_report',
            'export_report',
            
            // User Management
            'show_user_management',
            'add_user',
            'delete_user',
            'edit_user',
        ];

        foreach ($permissions as $permission) {
            Permission::firstOrCreate(['name' => $permission]);
        }

        // Reset cached roles and permissions
        app()[\Spatie\Permission\PermissionRegistrar::class]->forgetCachedPermissions();

        // Create roles and assign permissions
        $userRole = Role::firstOrCreate(['name' => 'user']);
        $userRole->syncPermissions(['show_cctv', 'show_legend', 'show_poi']);

        $adminRole = Role::firstOrCreate(['name' => 'admin']);
        $adminRole->syncPermissions(Permission::all());
    }
}
