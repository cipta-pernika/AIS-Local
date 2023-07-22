<?php

namespace App\Console\Commands;

use App\Models\RadarData;
use Carbon\Carbon;
use Illuminate\Console\Command;
use App\Models\Datalogger;
use Location\Coordinate;
use Location\Distance\Haversine;

class fetchradar extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'fetchradar';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $contents = file_get_contents('http://127.0.0.1:8160/tracks.json');
        $data = json_decode($contents);
        $distance = 0;

        foreach ($data->features as $feature) {
            $properties = $feature->properties;
            $geometry = $feature->geometry->coordinates;

            $datalogger = Datalogger::find(1);
            $coordinate1 = new Coordinate($datalogger->latitude, $datalogger->longitude);
            $coordinate2 = new Coordinate($geometry[1], $geometry[0]);
            $distance = $coordinate1->getDistance($coordinate2, new Haversine());
            $distanceInKilometers = $distance / 1000;
                        $distanceInNauticalMiles = $distanceInKilometers * 0.539957;

            RadarData::updateOrCreate(
                ['target_id' => $properties->name],
                [
                    'latitude' => $geometry[1],
                    'longitude' => $geometry[0],
                    'altitude' => $properties->altitude,
                    'speed' => $properties->speed,
                    'course' => $properties->course,
                    'heading' => $properties->heading,
                    'range' => $properties->range,
                    'bearing' => $properties->bearing,
                    'timestamp' => Carbon::now(),
                    'distance_from_fak' => $distanceInNauticalMiles
                ]
            );
        }

    }
}
