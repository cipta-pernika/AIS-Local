<?php

namespace App\Http\Controllers;

use App\Models\Asset;
use App\Models\Geofence;
use App\Models\GeofenceBinding;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;

class GeofenceController extends Controller
{
    public function setgeofence()
    {
        $geo = new Geofence();
        $geo->user_id = request('userId');
        $geo->geofence_name = request('name');
        $geo->type = request('typegeo');
        $geo->type_geo = request('typeShape');
        $geo->radius = request('radius');
        $geo->geometry = json_encode(request('geoDraw'));
        $geo->save();

        foreach (request('assetgeo') as $asset) {
            $geobinding = new GeofenceBinding;
            $geobinding->geofence_id = $geo->id;
            $geobinding->asset_id = $asset;
            $geobinding->save();
        }

        $geod = Geofence::where('id', $geo->id)
            ->first();

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
            ->join('asset', 'geofence_bindings.asset_id', 'assets.id')
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
        // $geo = Cache::remember('geofenceee', 120, function () {
        //     return Geofence::join('geofence_bindings', 'geofence_bindings.geofence_id', 'geofences.id')
        //         ->join('assets', 'geofence_bindings.asset_id', 'assets.id')
        //         ->groupBy('geofences.id')
        //         ->select(DB::raw('GROUP_CONCAT(DISTINCT assets.asset_name ORDER BY assets.id) AS assets_name'), 'geofences.type_geo', 'geofences.id', 'geometry', 'radius', 'type', 'geofence_name')
        //         ->get();
        // });

        $geo =  Geofence::all();

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
