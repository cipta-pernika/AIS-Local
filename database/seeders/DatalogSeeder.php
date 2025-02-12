<?php

namespace Database\Seeders;

use App\Models\Datalogger;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class DatalogSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        if (DB::getDriverName() == 'mongodb') {
            DB::connection('mongodb')
                ->selectCollection('dataloggers')
                ->insertOne([
                    'name' => 'Datalogger 1',
                    'serial_number' => 'DL001', 
                    'latitude' => -6.225699225611818,
                    'longitude' => 106.85030818477665,
                    'status' => 'Online',
                    'installation_date' => '2022-01-01',
                    'last_online' => '2023-05-24 12:34:56',
                ]);
        } else {
            Datalogger::create([
                'name' => 'Datalogger 1',
                'serial_number' => 'DL001',
                'latitude' => -6.225699225611818,
                'longitude' => 106.85030818477665,
                'status' => 'Online',
                'installation_date' => '2022-01-01',
                'last_online' => '2023-05-24 12:34:56',
            ]);
        }
    }
}
