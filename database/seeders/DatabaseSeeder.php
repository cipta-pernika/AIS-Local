<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call([DatalogSeeder::class, SensorSeeder::class, ShieldSeeder::class]);
        $this->call([
            // RadarDataSeeder::class,
            LocationTypeSeeder::class,
            LocationSeeder::class,
            AssetSeeder::class,
            // SensorDatasTableSeeder::class,
            // AisDataVesselsTableSeeder::class,
            // AisDataPositionsTableSeeder::class,
            EventSeeder::class,
            GeofenceTypesTableSeeder::class,
            UserSeeder::class,
            MapSettingSeeder::class,
            ModelHasRolesTableSeeder::class,
            PermissionsTableSeeder::class,
            RolesTableSeeder::class,
            RoleHasPermissionsTableSeeder::class,
            //paling akhir
            AdsbDataAircraftSeeder::class
        ]);
    }
}
