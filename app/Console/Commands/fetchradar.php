<?php

namespace App\Console\Commands;

use App\Models\RadarData;
use Illuminate\Console\Command;

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

foreach ($data->features as $feature) {
    $properties = $feature->properties;
    $geometry = $feature->geometry->coordinates;

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
        ]
    );
}

    }
}