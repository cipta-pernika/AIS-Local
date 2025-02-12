<?php

namespace Database\Seeders;

use App\Models\Sensor;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class SensorSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        if (DB::getDriverName() == 'mongodb') {
            DB::connection('mongodb')
                ->selectCollection('sensors')
                ->insertOne([
                    'datalogger_id' => '1',
                    'name' => 'Sensor 1',
                    'status' => 'Active',
                    'interval' => 60,
                    'jarak' => 100,
                    'jumlah_data' => 0,
                    'created_at' => now(),
                    'updated_at' => now(),
                ]);
        } else {
            Sensor::create([
                'datalogger_id' => 1,
                'name' => 'Sensor 1',
                'status' => 'Active',
                'interval' => 60,
                'jarak' => 100,
                'jumlah_data' => 0,
            ]);
        }

        // Sensor::create([
        //     'datalogger_id' => 1,
        //     'name' => 'RADAR',
        //     'status' => 'Active',
        //     'interval' => 5,
        //     'jarak' => 20,
        //     'jumlah_data' => 200,
        // ]);

        // Sensor::create([
        //     'datalogger_id' => 1,
        //     'name' => 'ADS-B',
        //     'status' => 'Active',
        //     'interval' => 5,
        //     'jarak' => 20,
        //     'jumlah_data' => 200,
        // ]);
    }
}
