<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Spatie\Permission\Models\Permission;
use App\Http\Resources\PermissionResource;

class PermissionController extends Controller
{
    public function __invoke(Request $request)
    {
        $limit = $request->input('limit', 15);
        $permissions = Permission::whereIn('name', [
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
            'edit_user'
        ])->paginate($limit);

        return PermissionResource::collection($permissions);
    }
}
