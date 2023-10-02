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
            'name' => 'AIS ON',
            'threshold' => 10,
        ]);

        Event::create([
            'name' => 'AIS OFF',
            'threshold' => 10,
        ]);
    }
}
