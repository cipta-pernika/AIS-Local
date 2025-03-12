<?php

namespace App\Console\Commands;

use App\Models\RadarData;
use Carbon\Carbon;
use Illuminate\Console\Command;
use App\Models\Datalogger;
use App\Models\EventTracking;
use App\Models\Geofence;
use App\Models\ReportGeofence;
use Illuminate\Support\Facades\Http;
use Location\Coordinate;
use Location\Distance\Haversine;
use Location\Polygon;

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
        try {
            $contents = file_get_contents('http://127.0.0.1:8160/tracks.json');
            $data = json_decode($contents);
            $distance = 0;

            foreach ($data->features as $feature) {
                $properties = $feature->properties;
                $geometry = $feature->geometry->coordinates;
                if ($geometry[1]) {

                    $datalogger = Datalogger::find(1);
                    $coordinate1 = new Coordinate($datalogger->latitude, $datalogger->longitude);
                    $coordinate2 = new Coordinate($geometry[1], $geometry[0]);
                    $distance = $coordinate1->getDistance($coordinate2, new Haversine());
                    $distanceInKilometers = $distance / 1000;
                    $distanceInNauticalMiles = $distanceInKilometers * 0.539957;

                    $radarData = RadarData::updateOrCreate(
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
                $defaultValue = env('APP_ENV_CHECK', 'local');
                $url = $defaultValue == 'local'
                    ? 'http://localhost:1880/sendgeofencealarmgmk'
                    : 'https://nr.monitormyvessel.com/sendgeofencealarmgmk';
                $geofenceDatas = Geofence::all();
                foreach ($geofenceDatas as $value) {
                    if ($value->geometry) {
                        $geoParse = json_decode($value->geometry);

                        if ($geoParse && $value->type_geo === 'circle') {
                            $jarak = $this->distance(
                                request()->latitude,
                                request()->longitude,
                                $geoParse->geometry->coordinates[1],
                                $geoParse->geometry->coordinates[0],
                                'K'
                            );
                            if ($jarak <= (float) $value['radius'] / 1000) {
                                if ($value['type'] === 'in' || $value['type'] === 'both') {
                                    $lastEventTimestamp = EventTracking::where('target_id', $radarData->target_id)
                                        ->where('geofence_id', $value['id'])
                                        ->whereDate('created_at', Carbon::today())
                                        ->value('created_at');

                                    // If no event recorded today, create a new event
                                    if (!$lastEventTimestamp || Carbon::parse($lastEventTimestamp)->diffInHours($radarData->timestamp) > 5) {
                                        EventTracking::create([
                                            'event_id' => 9,
                                            'target_id' => $radarData->target_id,
                                            'geofence_id' => $value['id']
                                        ]);
                                        $radarData->is_inside_geofence = 1;
                                        $radarData->update();

                                        try {
                                            Http::post($url, [
                                                'msg' => $radarData->target_id . ' Inside ' . $value['geofence_name'] . ' Geofence'
                                            ]);
                                        } catch (\Exception $e) {
                                            // Handle the exception here, you can log it or take appropriate action
                                            // For example:
                                            // Log::error('HTTP POST failed: ' . $e->getMessage());
                                        }
                                    }
                                }
                                $existingReport = ReportGeofence::where('geofence_id', $value['id'])
                                    ->where('target_id', $radarData->target_id)
                                    ->orderBy('in', 'desc')
                                    ->first();
                                if (!$existingReport || $existingReport->in->diffInHours(Carbon::parse($radarData->timestamp)) > 5) {
                                    ReportGeofence::updateOrCreate(
                                        [
                                            'target_id' => $radarData->target_id,
                                        ],
                                        [
                                            'event_id' => 9,
                                            'geofence_id' => $value['id'],
                                            'in' => Carbon::parse($radarData->timestamp)
                                        ]
                                    );
                                }
                            } else {
                                $washere = EventTracking::where('target_id', $radarData->target_id)
                                    ->where('event_id', 9)->where('geofence_id', $value['id'])->first();
                                if ($washere) {
                                    $existingReport = ReportGeofence::where('target_id', $radarData->target_id)
                                        ->where('geofence_id', $value['id'])
                                        ->whereNull('out')
                                        ->whereNotNull('in')
                                        ->first();

                                    if ($existingReport) {
                                        $existingReport->update([
                                            'out' => Carbon::parse($radarData->timestamp),
                                            'total_time' => $existingReport->in->diffInMinutes($radarData->timestamp)
                                        ]);
                                        EventTracking::create([
                                            'event_id' => 10,
                                            'target_id' => $radarData->target_id,
                                            'geofence_id' => $value['id']
                                        ]);

                                        $message = $radarData->target_id . ' Outside ' . $value['geofence_name'] . ' Geofence';
                                        try {
                                            Http::post($url, ['msg' => $message]);
                                        } catch (\Exception $e) {
                                        }
                                    }
                                }
                            }
                        } else if ($geoParse && ($value->type_geo === 'polygon' || $value->type_geo === 'rectangle')) {
                            // Handle polygon or rectangle case
                            $geofence = new Polygon();
                            foreach ($geoParse as $valGeo) {
                                $geofence->addPoint(new Coordinate($valGeo[0], $valGeo[1]));
                            }
                            $insidePoint = new Coordinate(request()->latitude,  request()->longitude);
                            if ($geofence->contains($insidePoint)) {
                                if ($value['type'] === 'in' || $value['type'] === 'both') {
                                    $lastEventTimestamp = EventTracking::where('target_id', $radarData->target_id)
                                        ->where('geofence_id', $value['id'])
                                        ->whereDate('created_at', Carbon::today())
                                        ->value('created_at');

                                    // If no event recorded today, create a new event
                                    if (!$lastEventTimestamp || Carbon::parse($lastEventTimestamp)->diffInHours($radarData->timestamp) > 5) {
                                        EventTracking::create([
                                            'event_id' => 9,
                                            'target_id' => $radarData->target_id,
                                            'geofence_id' => $value['id']
                                        ]);
                                        $radarData->is_inside_geofence = 1;
                                        $radarData->update();
                                        try {
                                            Http::post($url, [
                                                'msg' => $radarData->target_id . ' Inside ' . $value['geofence_name'] . ' Geofence'
                                            ]);
                                        } catch (\Exception $e) {
                                        }
                                    }
                                }
                                $existingReport = ReportGeofence::where('geofence_id', $value['id'])
                                    ->where('target_id', $radarData->target_id)
                                    ->orderBy('in', 'desc')
                                    ->first();
                                if (!$existingReport || $existingReport->in->diffInHours(Carbon::parse($radarData->timestamp)) > 5) {
                                    ReportGeofence::updateOrCreate(
                                        [
                                            'target_id' => $radarData->target_id,
                                        ],
                                        [
                                            'event_id' => 9,
                                            'geofence_id' => $value['id'],
                                            'in' => Carbon::parse($radarData->timestamp)
                                        ]
                                    );
                                }
                            } else {
                                $washere = EventTracking::where('target_id', $radarData->target_id)
                                    ->where('event_id', 9)->where('geofence_id', $value['id'])->first();
                                if ($washere) {
                                    $existingReport = ReportGeofence::where('target_id', $radarData->target_id)
                                        ->where('geofence_id', $value['id'])
                                        ->whereNull('out')
                                        ->whereNotNull('in')
                                        ->first();

                                    if ($existingReport) {
                                        $existingReport->update([
                                            'out' => Carbon::parse($radarData->timestamp),
                                            'total_time' => $existingReport->in->diffInMinutes($radarData->timestamp)
                                        ]);

                                        EventTracking::create([
                                            'event_id' => 10,
                                            'target_id' => $radarData->target_id,
                                            'geofence_id' => $value['id']
                                        ]);
                                        try {
                                            Http::post($url, [
                                                'msg' => $radarData->target_id . ' Outside ' . $value['geofence_name'] . ' Geofence'
                                            ]);
                                        } catch (\Exception $e) {
                                        }
                                    }
                                }
                            }
                        } else {
                            // Handle other cases
                            $isInside = [];
                        }
                    }
                }
            }
        } catch (\Exception $e) {
            // Log the error
            \Log::error('Error in fetchradar: ' . $e->getMessage());
        }
    }
}
