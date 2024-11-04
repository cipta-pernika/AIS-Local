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

    public function store(RoleRequest $request): JsonResponse
    {
        try {
            $resource = Role::create($request->all());
            return response()->json($resource, Response::HTTP_CREATED);

        } catch (\Exception $e) {
            return response()->json(['message' => $e->getMessage()], Response::HTTP_BAD_REQUEST);
        }
    }


    public function show(Role $role): JsonResponse
    {
        try {
            return response()->json($role, Response::HTTP_OK);

        } catch (\Exception $e) {
            return response()->json(['message' => $e->getMessage()], Response::HTTP_BAD_REQUEST);
        }
    }


    public function update(RoleRequest $request, Role $role): JsonResponse
    {
        try {
            $role->update($request->all());
            return response()->json($role, Response::HTTP_OK);

        } catch (\Exception $e) {
            return response()->json(['message' => $e->getMessage()], Response::HTTP_BAD_REQUEST);
        }
    }


    public function destroy(Role $role): JsonResponse
    {
        try {
            $role->delete();
            return response()->json($role, Response::HTTP_OK);

        } catch (\Exception $e) {
            return response()->json(['message' => $e->getMessage()], Response::HTTP_BAD_REQUEST);
        }
    }
}
