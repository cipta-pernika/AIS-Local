<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class GeofenceTypesTableSeeder extends Seeder
{

    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {
        

        \DB::table('geofence_types')->delete();
        
        \DB::table('geofence_types')->insert(array (
            0 => 
            array (
                'id' => 1,
                'name' => 'Kabel Laut',
                'base_price' => '',
                'uom' => '',
                'vessel_type' => '',
                'created_at' => '2023-11-30 06:27:34',
                'updated_at' => '2023-11-30 06:28:24',
            ),
            1 => 
            array (
                'id' => 2,
                'name' => 'Bongkar Muat',
                'base_price' => '10000.00',
                'uom' => 'Hours',
                'vessel_type' => '["Fishing","Tug"]',
                'created_at' => '2023-11-30 06:27:34',
                'updated_at' => '2023-11-30 06:28:24',
            ),
        ));
        
        
    }
}