<?php

namespace App\Console\Commands;

use App\Mail\GeofenceMail;
use App\Models\AisDataPosition;
use App\Models\EventTracking;
use App\Models\Geofence;
use App\Models\ReportGeofence;
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
        $geofence_datas = Geofence::all();
        $ais_datas = AisDataPosition::limit(700)->where('is_geofence', 0)->orderBy('created_at', 'DESC')->get();

        foreach ($geofence_datas as $geofence) {
            $geoParse = json_decode($geofence->geometry);
            if ($geofence->geometry && $geofence->type_geo === 'circle') {

                foreach ($ais_datas as $ais_data) {
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
                            $existingEvent = EventTracking::where('mmsi', $ais_data->mmsi)
                                ->where('created_at', '>', now()->subMinutes(15))
                                ->first();
                            if (!$existingEvent) {
                                EventTracking::create([
                                    'event_id' => 9,
                                    'ais_data_position_id' => $ais_data->id,
                                    'mmsi' => $ais_data->mmsi,
                                    'geofence_id' => $geofence->id
                                ]);
                                $ais_data->is_inside_geofence = 1;
                                $ais_data->update();

                                $report = ReportGeofence::where('mmsi', $ais_data->mmsi)->whereNull('out')->get();

                                if (!$report) {
                                    $geofence_report = new ReportGeofence;
                                    $geofence_report->event_id = 9;
                                    $geofence_report->ais_data_position_id = $ais_data->id;
                                    $geofence_report->geofence_id = $geofence->id;
                                    $geofence_report->mmsi = $ais_data->mmsi;
                                    $geofence_report->in = Carbon::now();
                                    $geofence_report->save();
                                }
                            }
                        }
                    } else {
                        if ($geofence->type === 'out' || $geofence->type === 'both') {
                            // Check if an EventTracking record already exists for the same MMSI within the last 15 minutes
                            $existingEvent = EventTracking::where('mmsi', $ais_data->mmsi)
                                ->where('created_at', '>', now()->subMinutes(15))
                                ->first();
                            if (!$existingEvent) {
                                EventTracking::create([
                                    'event_id' => 10,
                                    'ais_data_position_id' => $ais_data->id,
                                    'mmsi' => $ais_data->mmsi,
                                    'geofence_id' => $geofence->id
                                ]);

                                $report = ReportGeofence::where('mmsi', $ais_data->mmsi)->whereNull('out')->get();

                                if ($report) {
                                    $geofence_report = new ReportGeofence;
                                    $geofence_report->event_id = 9;
                                    $geofence_report->ais_data_position_id = $ais_data->id;
                                    $geofence_report->geofence_id = $geofence->id;
                                    $geofence_report->mmsi = $ais_data->mmsi;
                                    $geofence_report->out = Carbon::now();
                                    $geofence_report->save();
                                }
                            }
                        }
                    }
                }
            } elseif ($geofence->geometry && ($geofence->type_geo === 'polygon' || $geofence->type_geo === 'rectangle')) {
                foreach ($ais_datas as $ais_data) {
                    $polygon = new Polygon();
                    foreach ($geoParse as $valGeo) {
                        $polygon->addPoint(new Coordinate($valGeo[0], $valGeo[1]));
                    }
                    $insidePoint = new Coordinate($ais_data->latitude,  $ais_data->longitude);
                    if ($polygon->contains($insidePoint)) {
                        if ($geofence->type === 'in' || $geofence->type === 'both') {
                            EventTracking::create([
                                'event_id' => 9,
                                'ais_data_position_id' => $ais_data->id,
                                'mmsi' => $ais_data->mmsi,
                                'geofence_id' => $geofence->id
                            ]);
                            $ais_data->is_inside_geofence = 1;
                            $ais_data->update();
                            Http::post('https://nr.monitormyvessel.com/sendgeofencealarm', [
                                'msg' => $ais_data->vessel->vessel_name . ' Inside ' . $geofence->geofence_name . ' Geofence'
                            ]);
                        }
                    } else {
                        if ($geofence->type === 'out' || $geofence->type === 'both') {
                            EventTracking::create([
                                'event_id' => 10,
                                'ais_data_position_id' => $ais_data->id,
                                'mmsi' => $ais_data->mmsi,
                                'geofence_id' => $geofence->id
                            ]);
                            Http::post('https://nr.monitormyvessel.com/sendgeofencealarm', [
                                'msg' => $ais_data->vessel->vessel_name . ' Outside ' . $geofence->geofence_name . ' Geofence'
                            ]);
                        }
                    }
                }
            } else {
                foreach ($ais_datas as $ais_data) {
                }
            }
        }
    }
}
