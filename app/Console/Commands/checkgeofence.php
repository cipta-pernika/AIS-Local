<?php

namespace App\Console\Commands;

use App\Mail\GeofenceMail;
use App\Models\AisDataPosition;
use App\Models\EventTracking;
use App\Models\Geofence;
use Carbon\Carbon;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Mail;
use Location\Bearing\BearingSpherical;
use Location\Coordinate;
use Location\Distance\Haversine;
use Location\Distance\Vincenty;
use Location\Polygon;

class checkgeofence extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:checkgeofence';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Check Geofence';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $geofenceDatas = Geofence::all();
        $aisDatas = AisDataPosition::limit(700)
            ->where('is_geofence', 0)
            ->with('vessel')
            ->orderByDesc('created_at')
            ->get();

        foreach ($geofenceDatas as $geofence) {
            $geoParse = json_decode($geofence->geometry);
            if ($geofence->geometry && $geofence->type_geo === 'circle') {

                foreach ($aisDatas as $ais_data) {
                    $ais_data->is_geofence = 1;
                    $ais_data->update();
                    $jarak = $this->distance(
                        $ais_data->latitude,
                        $ais_data->longitude,
                        $geoParse->geometry->coordinates[1],
                        $geoParse->geometry->coordinates[0],
                        'K'
                    );
                    if ($jarak <= (float) $geofence['radius'] / 1000) {
                        if ($geofence->type === 'in' || $geofence->type === 'both') {
                            // Check if an EventTracking record already exists for the same MMSI within the last 15 minutes
                            $existingEvent = EventTracking::where('mmsi', $ais_data->vessel->mmsi)
                                ->where('created_at', '>', now()->subMinutes(15))
                                ->first();
                            if (!$existingEvent) {
                                EventTracking::create([
                                    'event_id' => 9,
                                    'ais_data_position_id' => $ais_data->id,
                                    'mmsi' => $ais_data->vessel->mmsi,
                                    'geofence_id' => $geofence->id
                                ]);
                                $ais_data->is_inside_geofence = 1;
                                $ais_data->update();
                            }
                        }
                    } else {
                        if ($geofence->type === 'out' || $geofence->type === 'both') {
                            // Check if an EventTracking record already exists for the same MMSI within the last 15 minutes
                            $existingEvent = EventTracking::where('mmsi', $ais_data->vessel->mmsi)
                                ->where('created_at', '>', now()->subMinutes(15))
                                ->first();
                            if (!$existingEvent) {
                                $washere = EventTracking::where('mmsi', $ais_data->vessel->mmsi)->where('event_id', 9)->first();
                                if ($washere) {
                                    EventTracking::create([
                                        'event_id' => 10,
                                        'ais_data_position_id' => $ais_data->id,
                                        'mmsi' => $ais_data->vessel->mmsi,
                                        'geofence_id' => $geofence->id
                                    ]);
                                }
                            }
                        }
                    }
                }
            } else if ($geofence->geometry && ($geofence->type_geo === 'polygon' || $geofence->type_geo === 'rectangle')) {
                foreach ($aisDatas as $ais_data) {
                    $ais_data->is_geofence = 1;
                    $ais_data->update();
                    $polygon = new Polygon();
                    foreach ($geoParse as $valGeo) {
                        $polygon->addPoint(new Coordinate($valGeo[0], $valGeo[1]));
                    }
                    $insidePoint = new Coordinate($ais_data->latitude,  $ais_data->longitude);
                    if ($polygon->contains($insidePoint)) {
                        if ($geofence->type === 'in' || $geofence->type === 'both') {
                            $existingEvent = EventTracking::where('mmsi', $ais_data->vessel->mmsi)
                                ->where('created_at', '>', now()->subMinutes(15))
                                ->first();
                            if (!$existingEvent) {

                                EventTracking::create([
                                    'event_id' => 9,
                                    'ais_data_position_id' => $ais_data->id,
                                    'mmsi' => $ais_data->vessel->mmsi,
                                    'geofence_id' => $geofence->id
                                ]);
                                $ais_data->is_inside_geofence = 1;
                                $ais_data->update();
                                Http::post('https://nr.monitormyvessel.com/sendgeofencealarmgmk', [
                                    'msg' => $ais_data->vessel->vessel_name . ' Inside ' . $geofence->geofence_name . ' Geofence'
                                ]);
                            }
                        }
                    } else {
                        if ($geofence->type === 'out' || $geofence->type === 'both') {
                            $existingEvent = EventTracking::where('mmsi', $ais_data->vessel->mmsi)
                                ->where('created_at', '>', now()->subMinutes(15))
                                ->first();
                            if (!$existingEvent) {
<<<<<<< HEAD
                                $washere = EventTracking::where('mmsi', $ais_data->vessel->mmsi)->where('event_id', 9)->first();
                                if ($washere) {
                                    EventTracking::create([
                                        'event_id' => 10,
                                        'ais_data_position_id' => $ais_data->id,
                                        'mmsi' => $ais_data->vessel->mmsi,
                                        'geofence_id' => $geofence->id
                                    ]);
                                    Http::post('https://nr.monitormyvessel.com/sendgeofencealarm', [
                                        'msg' => $ais_data->vessel->vessel_name . ' Outside ' . $geofence->geofence_name . ' Geofence'
                                    ]);
                                }
=======

                                EventTracking::create([
                                    'event_id' => 10,
                                    'ais_data_position_id' => $ais_data->id,
                                    'mmsi' => $ais_data->vessel->mmsi,
                                    'geofence_id' => $geofence->id
                                ]);
                                Http::post('https://nr.monitormyvessel.com/sendgeofencealarmgmk', [
                                    'msg' => $ais_data->vessel->vessel_name . ' Outside ' . $geofence->geofence_name . ' Geofence'
                                ]);
>>>>>>> coastal
                            }
                        }
                    }
                }
            } else {
                foreach ($aisDatas as $ais_data) {
                }
            }
        }
    }

    public function distance($lat1, $lon1, $lat2, $lon2, $unit)
    {
        if (($lat1 == $lat2) && ($lon1 == $lon2)) {
            return 0;
        } else {
            $theta = $lon1 - $lon2;
            $dist = sin(deg2rad($lat1)) * sin(deg2rad($lat2)) + cos(deg2rad($lat1)) * cos(deg2rad($lat2)) * cos(deg2rad($theta));
            $dist = acos($dist);
            $dist = rad2deg($dist);
            $miles = $dist * 60 * 1.1515;
            $unit = strtoupper($unit);

            if ($unit == "K") {
                return ($miles * 1.609344);
            } else if ($unit == "N") {
                return ($miles * 0.8684);
            } else {
                return $miles;
            }
        }
    }
}
