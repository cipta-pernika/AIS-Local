<?php

namespace App\Console\Commands;

use App\Mail\GeofenceMail;
use App\Models\AisDataPosition;
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

class checkreportgeofence extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:checkreportgeofence';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Check Report Geofence';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $geofenceDatas = Geofence::all();
        $aisDatas = AisDataPosition::limit(700)
            ->with('vessel')
            ->orderByDesc('created_at')
            ->get();

        foreach ($geofenceDatas as $geofence) {
            $geoParse = json_decode($geofence->geometry);
            $isInside = false;

            if ($geofence->geometry && $geofence->type_geo === 'circle') {
                $isInside = $this->isInsideCircle($aisDatas, $geoParse, $geofence);
            } elseif ($geofence->geometry && ($geofence->type_geo === 'polygon' || $geofence->type_geo === 'rectangle')) {
                $isInside = $this->isInsidePolygon($aisDatas, $geoParse, $geofence);
            }

            if ($isInside && ($geofence->type === 'in' || $geofence->type === 'both')) {
                $this->createReportGeofence($aisDatas, $geofence, 'in');
            } elseif (!$isInside && ($geofence->type === 'out' || $geofence->type === 'both')) {
                $this->createReportGeofence($aisDatas, $geofence, 'out');
            }
        }
    }

    private function isInsideCircle($aisDatas, $geoParse, $geofence)
    {
        foreach ($aisDatas as $ais_data) {
            $distance = $this->distance(
                $ais_data->latitude,
                $ais_data->longitude,
                $geoParse->geometry->coordinates[1],
                $geoParse->geometry->coordinates[0],
                'K'
            );

            if ($distance <= (float) $geofence['radius'] / 1000) {
                return true;
            }
        }

        return false;
    }

    private function isInsidePolygon($aisDatas, $geoParse, $geofence)
    {
        $polygon = new Polygon();

        foreach ($geoParse as $valGeo) {
            $polygon->addPoint(new Coordinate($valGeo[0], $valGeo[1]));
        }

        foreach ($aisDatas as $ais_data) {
            $insidePoint = new Coordinate($ais_data->latitude, $ais_data->longitude);

            if ($polygon->contains($insidePoint)) {
                return true;
            }
        }

        return false;
    }

    private function createReportGeofence($aisDatas, $geofence, $eventType)
    {
        foreach ($aisDatas as $ais_data) {
            $report = ReportGeofence::where('mmsi', $ais_data->vessel->mmsi)
                ->whereNull('out')
                ->whereNotNull('in')
                ->get();

            if ($report->isEmpty() && $eventType === 'in') {
                // Check if the vessel is already inside the geofence, don't create a new record
                $existingReportInside = ReportGeofence::where('mmsi', $ais_data->vessel->mmsi)
                    ->where('geofence_id', $geofence->id)
                    ->whereNull('out')
                    ->whereNotNull('in')
                    ->first();

                if (!$existingReportInside) {
                    ReportGeofence::updateOrCreate(
                        [
                            'ais_data_position_id' => $ais_data->id,
                        ],
                        [
                            'event_id' => 9,
                            'geofence_id' => $geofence->id,
                            'mmsi' => $ais_data->vessel->mmsi,
                            $eventType => Carbon::parse($ais_data->timestamp)
                        ]
                    );
                }
            } elseif ($report->isNotEmpty() && $eventType === 'out') {
                // Update the existing record when the vessel exits the geofence
                $existingReport = ReportGeofence::where('mmsi', $ais_data->vessel->mmsi)
                    ->where('geofence_id', $geofence->id)
                    ->whereNull('out')
                    ->whereNotNull('in')
                    ->first();

                if ($existingReport) {
                    $existingReport->update([
                        'out' => Carbon::now(),
                    ]);
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
