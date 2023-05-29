<?php

namespace Database\Seeders;

use App\Models\Sensor;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class SensorSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Sensor::create([
            'datalogger_id' => 1,
            'name' => 'AIS',
            'status' => 'Active',
            'interval' => 5,
            'jarak' => 20,
            'jumlah_data' => 200,
        ]);
    }
}
