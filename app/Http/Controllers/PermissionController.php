<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Spatie\Permission\Models\Permission;
use App\Http\Resources\PermissionResource;

class PermissionController extends Controller
{
    public function __invoke(Request $request)
    {
        $permissions = Permission::paginate();

        return PermissionResource::collection($permissions);
    }
}
