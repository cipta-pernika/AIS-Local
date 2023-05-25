<?php

namespace Database\Seeders;

use App\Models\Datalogger;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DataLoggerSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Datalogger::create([
            'name' => 'Datalogger 1',
            'serial_number' => 'DL001',
            'latitude' => 123.456789,
            'longitude' => 987.654321,
            'status' => 'Online',
            'installation_date' => '2022-01-01',
            'last_online' => '2023-05-24 12:34:56',
        ]);
    }
}
