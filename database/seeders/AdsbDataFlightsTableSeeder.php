<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class AdsbDataFlightsTableSeeder extends Seeder
{

    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {
        

        \DB::table('adsb_data_flights')->delete();
        
        \DB::table('adsb_data_flights')->insert(array (
            0 => 
            array (
                'id' => 1,
                'aircraft_id' => NULL,
                'flight_number' => '1',
                'date' => NULL,
                'from' => NULL,
                'to' => NULL,
                'flight_time' => NULL,
                'std' => NULL,
                'atd' => NULL,
                'sta' => NULL,
                'created_at' => '2023-06-23 04:33:03',
                'updated_at' => '2023-06-23 04:33:03',
            ),
        ));
        
        
    }
}