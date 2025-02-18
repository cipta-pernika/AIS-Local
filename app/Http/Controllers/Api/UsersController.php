<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\ModelHasPermission;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use Spatie\Permission\Models\Permission;

// use Spatie\Permission\Models\Permission;

class UsersController extends Controller
{
    // public function index()
    // {
    //     $dataloggers = User::all();
    //     return response()->json($dataloggers);
    // }
    
    public function index()
    {
        $dataloggers = User::with('permissions')->get();
        $dataWithPermissions = $dataloggers->map(function ($user) {
            return [
                'user' => $user,
                // 'permissions' => $user->getPermissionNames(), // Menggunakan Spatie untuk mendapatkan nama permission
    
            ];
        });
    
        return response()->json([
            'data' => $dataWithPermissions,
        ]);
    }

    // public function store(Request $request)
    // {
    //     $validator = Validator::make($request->all(), [
    //         'name' => 'required|string',
    //         'email' => 'required|email|unique:users',
    //         'password' => 'required|string',
    //     ]);

    //     if ($validator->fails()) {
    //         return response()->json(['error' => $validator->errors()], 422);
    //     }
    //     $data = $request->all();
    //     $data['password'] = Hash::make($request->input('password'));
    //     $datalogger = User::create($data);
    //     return response()->json($datalogger, 201);
    // }
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string',
            'email' => 'required|email|unique:users',
            'password' => 'required|string',
            'permission' => 'required|array',
            'permission.*.value' => 'required|string',
            'permission.*.checked' => 'required|boolean',
        ]);

        if ($validator->fails()) {
            return response()->json(['error' => $validator->errors()], 422);
        }

        $data = $request->only(['name', 'email', 'password']);
        $data['password'] = Hash::make($request->input('password'));
        $user = User::create($data);

        // Simpan permission ke tabel model_has_permissions
        foreach ($request->input('permission') as $perm) {
            if ($perm['checked']) {
                $permission = Permission::where('name', $perm['value'])->first();
                // dd($permission);
                if ($permission) {
                    DB::table('model_has_permissions')->insert([
                        'permission_id' => $permission->id,
                        'model_type' => User::class,
                        'model_id' => $user->id,
                    ]);
                }
            }
        }

        return response()->json($user, 201);
    }

    public function show($id)
    {
        $datalogger = User::find($id);

        if (!$datalogger) {
            return response()->json(['error' => 'Data not found'], 404);
        }

        return response()->json($datalogger);
    }

    public function update(Request $request, User $user)
{
    if (!$user) {
        return response()->json(['error' => 'Data not found'], 404);
    }

    $validator = Validator::make($request->all(), [
        'name' => 'string',
        'password' => 'string',
        'latitude' => 'numeric',
        'longitude' => 'numeric',
        'status' => 'string',
        'installation_date' => 'date',
        'last_online' => 'date',
        'permission' => 'array',
        'permission.*.value' => 'string',
        'permission.*.checked' => 'boolean',
    ]);

    if ($validator->fails()) {
        return response()->json(['error' => $validator->errors()], 422);
    }

    $userData = $request->except('permission'); // Exclude permissions from user data

    

    // Hash the password if it's provided in the request
    if (isset($userData['password'])) {
        $userData['password'] = bcrypt($userData['password']);
    }

    $user->update($userData);

       // Update permissions
       if ($request->has('permission')) {
        $permissions = $request->input('permission');
        $permissionNames = collect($permissions)
            ->filter(fn($perm) => $perm['checked'])
            ->pluck('value')
            ->toArray();

        // Ensure permissions exist in the database
        $existingPermissions = Permission::whereIn('name', $permissionNames)->pluck('name')->toArray();

        // Use syncPermissions to avoid duplicate entries
        $user->syncPermissions($existingPermissions);

        foreach ($request->input('permission') as $perm) {
            if ($perm['checked']) {
                $permission = ModelHasPermission::where('model_id', $user->id)->update(['model_type' => 'App\Models\User']);
            }
        }
    }


    return response()->json([
        'message' => 'User updated successfully',
        'data' => $user
    ]);
}

    public function destroy(User $datalogger)
    {
        if (!$datalogger) {
            return response()->json(['error' => 'Data not found'], 404);
        }

        $datalogger->delete();
        return response()->json(['message' => 'Data deleted successfully']);
    }
}
