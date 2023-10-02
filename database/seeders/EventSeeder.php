<?php

namespace Database\Seeders;

use App\Models\Event;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class EventSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Event::create([
            'name' => 'Normal Positions',
            'threshold' => 10,
        ]);

        Event::create([
            'name' => 'ON AIS',
            'threshold' => 10,
        ]);

        Event::create([
            'name' => 'OFF AIS',
            'threshold' => 10,
        ]);

        Event::create([
            'name' => 'ON AIS Receiver Coverage',
            'threshold' => 10,
        ]);

        Event::create([
            'name' => 'OFF AIS Receiver Coverage',
            'threshold' => 10,
        ]);

        Event::create([
            'name' => 'Entry coverage AIS (new detected)',
            'threshold' => 10,
        ]);

        Event::create([
            'name' => 'Entry coverage AIS (new detected)',
            'threshold' => 10,
        ]);
    }
}
