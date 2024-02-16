<?php

namespace Database\Seeders;

use DateTime;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class LocationTypeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('location_types')->insert([
            [
                'name' => 'Default Marker',
                'description' => 'Default Marker',
                
                'icon' => 'images\locicon\loc.png',
                'color' => '#FA4D56',
                'created_at' => new DateTime(),
                'updated_at' => new DateTime
            ],
            [
                'name' => 'Building',
                'description' => 'Default Building Icon',
                'color' => '#FA4D56',
                'icon' => 'images\locicon\building1.png',
                'created_at' => new DateTime,
                'updated_at' => new DateTime
            ],
            [
                'name' => 'Offshore Helideck',
                'description' => 'Offshore Helideck Description',
                'color' => '#FA4D56',
                'icon' => 'images\locicon\helideck.png',
                'created_at' => new DateTime,
                'updated_at' => new DateTime
            ],
            [
                'name' => 'Radio Tower',
                'description' => 'Radio Tower Description',
                'color' => '#FA4D56',
                'icon' => 'images\locicon\radiotower.png',
                'created_at' => new DateTime,
                'updated_at' => new DateTime
            ],
            [
                'name' => 'Company Heliport',
                'description' => 'Company Heliport Description',
                'color' => '#FA4D56',
                'icon' => 'images\locicon\heliport.png',
                'created_at' => new DateTime,
                'updated_at' => new DateTime
            ],
            [
                'name' => 'Enroute Waypoint',
                'description' => 'Enroute Waypoint Description',
                'color' => '#FA4D56',
                'icon' => 'images\locicon\enroute.png',
                'created_at' => new DateTime,
                'updated_at' => new DateTime
            ],
            [
                'name' => 'Generic Points',
                'description' => 'Generic Point Description',
                'color' => '#FA4D56',
                'icon' => 'images\new_icon\new_pin_1.svg',
                'created_at' => new DateTime,
                'updated_at' => new DateTime
            ],
            [
                'name' => 'Communication Centre',
                'description' => 'Default Description',
                'icon' => 'images/locicon/482374whatsapp-icon-png-715x715.png',
                'color' => '#FA4D56',
                'created_at' => new DateTime,
                'updated_at' => new DateTime
            ],
            [
                'name' => 'Terminal',
                'description' => 'Terminal',
                'icon' => 'images\locicon\loc.png',
                'color' => '#FA4D56',
                'created_at' => new DateTime(),
                'updated_at' => new DateTime
            ],
        ]);
    }
}
