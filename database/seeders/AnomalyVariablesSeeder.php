<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class AnomalyVariablesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('anomaly_variables')->insert([
            [
                'name' => 'To Long Anchored',
                'description' => 'Vessel has been anchored for too long',
                'unit' => 'minutes',
                'type' => 'time',
                'value' => '5'
            ],
            [
                'name' => 'To Long Berthing',
                'description' => 'Vessel has been berthed for too long',
                'unit' => 'minutes',
                'type' => 'time',
                'value' => '5'
            ],
            [
                'name' => 'AIS OFF',
                'description' => 'AIS signal is off',
                'unit' => 'minutes',
                'type' => 'time',
                'value' => '5'
            ],
        ]);
    }
}
