<?php

namespace Database\Seeders;

use DateTime;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class LocationSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('locations')->insert([

            [
                'name' => 'Starbuck',
                
                'location_type_id' => 4,
                'latitude' => '-5.95707037',
                'longitude' => '106.02221497',
                'created_at' => new DateTime(),
                'updated_at' => new DateTime
            ],
            [
                
                'name' => 'Heliport 12',
                
                'location_type_id' => 3,
                'latitude' => '-7.86510000',
                'longitude' => '107.09760000',
                'created_at' => new DateTime,
                'updated_at' => new DateTime
            ],
            [
                
                'name' => 'Menara Telkom',
                
                'location_type_id' => 4,
                'latitude' => '-6.69279626',
                'longitude' => '108.22984243',
                'created_at' => new DateTime,
                'updated_at' => new DateTime
            ]
        ]);
    }
}
