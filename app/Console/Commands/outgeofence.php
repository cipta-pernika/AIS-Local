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

class outgeofence extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:outgeofence';

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
        $geofenceDatas = Geofence::all();

        foreach ($geofenceDatas as $geofence) {
            $aisDatas = AisDataPosition::limit(700)
                ->with('vessel')
                ->orderByDesc('created_at')
                ->get();

            foreach ($aisDatas as $ais_data) {
                // Check if the AIS data position is outside the geofence
                if (!$this->isInside($ais_data, $geofence)) {
                    $existingReport = ReportGeofence::where('mmsi', $ais_data->vessel->mmsi)
                        ->where('geofence_id', $geofence->id)
                        ->whereNull('out')
                        ->whereNotNull('in')
                        ->first();

                    if ($existingReport) {
                        $existingReport->update([
                            'out' => Carbon::parse($ais_data->timestamp)
                        ]);
                    }
                }
            }
        }
    }

    private function isInside($ais_data, $geofence)
    {
        $geoParse = json_decode($geofence->geometry);

        if ($geofence->type_geo === 'circle') {
            return $this->isInsideCircle($ais_data, $geoParse, $geofence);
        } elseif ($geofence->type_geo === 'polygon' || $geofence->type_geo === 'rectangle') {
            return $this->isInsidePolygon($ais_data, $geoParse, $geofence);
        }

        return false;
    }

    private function isInsideCircle($ais_data, $geoParse, $geofence)
    {
        $distance = $this->distance(
            $ais_data->latitude,
            $ais_data->longitude,
            $geoParse->geometry->coordinates[1],
            $geoParse->geometry->coordinates[0],
            'K'
        );

        return $distance <= (float) $geofence['radius'] / 1000;
    }

    private function isInsidePolygon($ais_data, $geoParse, $geofence)
    {
        $polygon = new Polygon();

        foreach ($geoParse as $valGeo) {
            $polygon->addPoint(new \Location\Coordinate($valGeo[0], $valGeo[1]));
        }

        $insidePoint = new \Location\Coordinate($ais_data->latitude, $ais_data->longitude);

        return $polygon->contains($insidePoint);
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
