<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Resources\RoleResource;
use App\Models\Role;

class RoleController extends Controller
{
    public function __invoke(Request $request)
    {
        $roles = Role::paginate();

        return RoleResource::collection($roles);
    }
}
