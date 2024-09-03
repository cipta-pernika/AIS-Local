<?php

namespace App\Http\Controllers;

use App\Models\Asset;
use App\Models\EventTracking;
use App\Models\Geofence;
use App\Models\GeofenceBinding;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;

class GeofenceController extends Controller
{
    public function analytics()
    {
        // Calculate Average Duration Inside
        $averageDurationInside = 10;

        // Calculate Total Entries
        $totalEntries = DB::table('report_geofences')->count();

        // Calculate Maximum Speed, Minimum Speed, and Average Speed
        $maximumSpeed = DB::table('ais_data_positions')->max('speed');
        $minimumSpeed = DB::table('ais_data_positions')->min('speed');
        $averageSpeed = DB::table('ais_data_positions')->avg('speed');

        // Calculate Entries Per Hour
        $entriesPerHour = $totalEntries / Carbon::now()->diffInHours(Carbon::now()->subDay());

        // Calculate Average Stay Per Entry
        $averageStayPerEntry = 50;

        // Calculate Maximum Stay Time, Minimum Stay Time
        $maximumStayTime = DB::table('report_geofences')->max(DB::raw('TIMESTAMPDIFF(MINUTE, `in`, `out`)'));
        $minimumStayTime = DB::table('report_geofences')->min(DB::raw('TIMESTAMPDIFF(MINUTE, `in`, `out`)'));


        // Return the calculated values in JSON format
        return response()->json([
            'success' => true,
            'average_duration_inside' => $averageDurationInside,
            'total_entries' => $totalEntries,
            'maximum_speed' => $maximumSpeed,
            'minimum_speed' => $minimumSpeed,
            'average_speed' => $averageSpeed,
            'entries_per_hour' => $entriesPerHour,
            'average_stay_per_entry' => $averageStayPerEntry,
            'maximum_stay_time' => $maximumStayTime,
            'minimum_stay_time' => $minimumStayTime,
        ]);
    }

    public function totalentries()
    {
        $geofence = Geofence::find(request('geofence_id'));
        $event = null;

        if ($geofence) {
            $event = EventTracking::where('geofence_id', $geofence->id)
                ->whereBetween('created_at', [now()->subHours(24), now()])
                ->with('aisDataPosition', 'asset', 'event', 'geofence')
                ->get();
        }

        return response()->json([
            'success' => true,
            'message' => $event,
        ], 200);
    }

    public function setgeofence()
    {
        $geo = new Geofence();
        $geo->user_id = request('userId');
        $geo->geofence_name = request('name');
        $geo->type = request('typegeo');
        $geo->type_geo = request('typeShape');
        $geo->radius = request('radius');
        $geo->pelabuhan_id = request('pelabuhan_id');
        $geo->geofence_type_id = request('typeGeofence');
        $geo->geometry = json_encode(request('geoDraw'));
        $geo->save();

        foreach (request('assetgeo') as $asset) {
            $geobinding = new GeofenceBinding;
            $geobinding->geofence_id = $geo->id;
            $geobinding->asset_id = $asset;
            $geobinding->save();
        }

        $geod = Geofence::where('id', $geo->id)
            ->with('pelabuhan')
            ->first();

        Cache::forget('all_geofences');

        return response()->json([
            'success' => true,
            'message' => $geod,
        ], 200);
    }

    public function editGeofence()
    {
        $geo = Geofence::find(request('id'));

        if (!$geo) {
            return response()->json([
                'success' => false,
                'message' => 'Geofence not found.',
            ], 404); // Return a 404 Not Found response.
        }

        // Update geofence properties
        $geo->geofence_name = request('name');
        $geo->type = request('typegeo');
        $geo->update();

        // Delete existing geofence bindings
        GeofenceBinding::where('geofence_id', request('id'))->delete();

        // Create new geofence bindings
        if (is_array(request('assetgeo'))) {
            foreach (request('assetgeo') as $asset) {
                $geobinding = new GeofenceBinding;
                $geobinding->geofence_id = $geo->id;
                $geobinding->asset_id = $asset;
                $geobinding->save();
            }
        }

        $geod = Geofence::join('geofence_bindings', 'geofences.id', 'geofence_bindings.geofence_id')
            ->join('assets', 'geofence_bindings.asset_id', 'assets.id')
            ->where('geofences.id', $geo->id)
            ->select(
                DB::raw('GROUP_CONCAT(DISTINCT assets.asset_name ORDER BY assets.id) AS assets_name'),
                'geofences.type_geo',
                'geofences.id',
                'geometry',
                'radius',
                'type',
                'asset_id',
                'geofence_name'
            )
            ->first();

        return response()->json([
            'success' => true,
            'message' => $geod,
        ], 200);
    }


    public function getgeofence()
    {

        // Create a descriptive cache key
        $cacheKey = 'all_geofences';

        // Attempt to retrieve data from the cache
        $cachedData = Cache::get($cacheKey);

        if (!$cachedData) {
            // If not cached, fetch the data from the database
            $geo = Geofence::where('isMaster', 0)->get();

            // Store the retrieved data in the cache
            Cache::put($cacheKey, $geo, 60); // Cache for 60 minutes
        } else {
            // Data is already cached
            $geo = $cachedData;
        }

        return response()->json([
            'success' => true,
            'message' => $geo,
        ], 200);
    }

    public function deletegeofence()
    {
        $geo = Geofence::find(request('idGeo'));

        if ($geo) {
            $geo->delete();

            // You can uncomment this code if you also want to delete associated bindings
            $geoB = GeofenceBinding::where('geofence_id', request('idGeo'))->get();
            foreach ($geoB as $geoBe) {
                $geoBe->delete();
            }

            return response()->json([
                'success' => true,
                'message' => 'Geofence deleted successfully.',
            ], 200);
        } else {
            return response()->json([
                'success' => false,
                'message' => 'Geofence not found.',
            ], 404); // Return a 404 Not Found response.
        }
    }
}
