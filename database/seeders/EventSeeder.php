<?php

namespace Database\Seeders;

use App\Models\Event;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class EventSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        if (DB::getDriverName() == 'mongodb') {
            $events = [
                ['name' => 'Normal Positions', 'threshold' => 10],
                ['name' => 'ON AIS', 'threshold' => 10],
                ['name' => 'OFF AIS', 'threshold' => 10],
                ['name' => 'ON AIS Receiver Coverage', 'threshold' => 10],
                ['name' => 'OFF AIS Receiver Coverage', 'threshold' => 10],
                ['name' => 'Entry coverage AIS (new detected)', 'threshold' => 10],
                ['name' => 'Navigation status changes', 'threshold' => 10],
                ['name' => 'Potential Collision', 'threshold' => 10],
                ['name' => 'Enter Geofence', 'threshold' => 10],
                ['name' => 'Exit Geofence', 'threshold' => 10],
            ];

            foreach ($events as $event) {
                DB::connection('mongodb')
                    ->selectCollection('events')
                    ->insertOne($event);
            }
        } else {
            $events = [
                ['name' => 'Normal Positions', 'threshold' => 10],
                ['name' => 'ON AIS', 'threshold' => 10],
                ['name' => 'OFF AIS', 'threshold' => 10],
                ['name' => 'ON AIS Receiver Coverage', 'threshold' => 10],
                ['name' => 'OFF AIS Receiver Coverage', 'threshold' => 10],
                ['name' => 'Entry coverage AIS (new detected)', 'threshold' => 10],
                ['name' => 'Navigation status changes', 'threshold' => 10],
                ['name' => 'Potential Collision', 'threshold' => 10],
                ['name' => 'Enter Geofence', 'threshold' => 10],
                ['name' => 'Exit Geofence', 'threshold' => 10],
            ];

            foreach ($events as $event) {
                Event::create($event);
            }
        }
    }
}
