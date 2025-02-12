<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use BezhanSalleh\FilamentShield\Support\Utils;
use Illuminate\Support\Facades\DB;

class ShieldSeeder extends Seeder
{
    /**
    * Run the database seeds.
    *
    * @return void
    */
    public function run()
    {
        app()[\Spatie\Permission\PermissionRegistrar::class]->forgetCachedPermissions();

        $rolesWithPermissions = '[{"name":"panel_user","guard_name":"web","permissions":[]}]';
        $directPermissions = '[]';

        if (DB::getDriverName() == 'mongodb') {
            $this->makeMongoRolesWithPermissions($rolesWithPermissions);
            $this->makeMongoDirectPermissions($directPermissions);
        } else {
            static::makeRolesWithPermissions($rolesWithPermissions);
            static::makeDirectPermissions($directPermissions);
        }

        $this->command->info('Shield Seeding Completed.');
    }

    protected function makeMongoRolesWithPermissions(string $rolesWithPermissions): void
    {
        if (! blank($rolePlusPermissions = json_decode($rolesWithPermissions, true))) {
            foreach ($rolePlusPermissions as $rolePlusPermission) {
                DB::connection('mongodb')
                    ->selectCollection('roles')
                    ->updateOne(
                        [
                            'name' => $rolePlusPermission['name'],
                            'guard_name' => $rolePlusPermission['guard_name']
                        ],
                        [
                            '$set' => [
                                'name' => $rolePlusPermission['name'],
                                'guard_name' => $rolePlusPermission['guard_name']
                            ]
                        ],
                        ['upsert' => true]
                    );

                if (! blank($rolePlusPermission['permissions'])) {
                    foreach ($rolePlusPermission['permissions'] as $permission) {
                        DB::connection('mongodb')
                            ->selectCollection('permissions')
                            ->updateOne(
                                [
                                    'name' => $permission,
                                    'guard_name' => 'web'
                                ],
                                [
                                    '$set' => [
                                        'name' => $permission,
                                        'guard_name' => 'web'
                                    ]
                                ],
                                ['upsert' => true]
                            );
                    }
                }
            }
        }
    }

    protected function makeMongoDirectPermissions(string $directPermissions): void
    {
        if (! blank($permissions = json_decode($directPermissions, true))) {
            foreach($permissions as $permission) {
                DB::connection('mongodb')
                    ->selectCollection('permissions')
                    ->updateOne(
                        [
                            'name' => $permission['name'],
                            'guard_name' => $permission['guard_name']
                        ],
                        [
                            '$set' => [
                                'name' => $permission['name'],
                                'guard_name' => $permission['guard_name']
                            ]
                        ],
                        ['upsert' => true]
                    );
            }
        }
    }

    protected static function makeRolesWithPermissions(string $rolesWithPermissions): void
    {
        if (! blank($rolePlusPermissions = json_decode($rolesWithPermissions,true))) {

            foreach ($rolePlusPermissions as $rolePlusPermission) {
                $role = Utils::getRoleModel()::firstOrCreate([
                    'name' => $rolePlusPermission['name'],
                    'guard_name' => $rolePlusPermission['guard_name']
                ]);

                if (! blank($rolePlusPermission['permissions'])) {

                    $permissionModels = collect();

                    collect($rolePlusPermission['permissions'])
                        ->each(function ($permission) use($permissionModels) {
                            $permissionModels->push(Utils::getPermissionModel()::firstOrCreate([
                                'name' => $permission,
                                'guard_name' => 'web'
                            ]));
                        });
                    $role->syncPermissions($permissionModels);

                }
            }
        }
    }

    public static function makeDirectPermissions(string $directPermissions): void
    {
        if (! blank($permissions = json_decode($directPermissions,true))) {

            foreach($permissions as $permission) {

                if (Utils::getPermissionModel()::whereName($permission)->doesntExist()) {
                    Utils::getPermissionModel()::create([
                        'name' => $permission['name'],
                        'guard_name' => $permission['guard_name'],
                    ]);
                }
            }
        }
    }
}
