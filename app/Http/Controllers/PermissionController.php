<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Spatie\Permission\Models\Permission;
use App\Http\Resources\PermissionResource;

class PermissionController extends Controller
{
    public function __invoke(Request $request)
    {
        $limit = $request->input('limit', 15); // Default to 15 items per page
        $permissions = Permission::paginate($limit);

        return PermissionResource::collection($permissions);
    }
}
