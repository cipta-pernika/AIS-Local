<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class MapSettingSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('map_settings')->insert([
            'user_id' => 1,
            'distance_unit' => 'km',
            'speed_unit' => 'km/h',
            'breadcrumb' => '',
            'breadcrumb_point' => 10,
            'time_zone' => 'UTC',
            'coordinate_format' => 'decimal',
            'created_at' => now(),
            'updated_at' => now(),
        ]);
    }
}
