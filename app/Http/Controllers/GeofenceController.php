<?php

namespace App\Http\Controllers;

use App\Models\Geofence;
use Illuminate\Http\Request;

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
            $device = Device::where('asset_id', $asset)->first();
            $geobinding = new GeofenceBinding;
            $geobinding->geofence_id = $geo->id;
            $geobinding->device_imei = $device->device_imei;
            $geobinding->asset_id = $asset;
            $geobinding->save();
        }

        $geod = Geofence::join('geofence_binding', 'geofence.id', 'geofence_binding.geofence_id')
            ->join('asset', 'geofence_binding.asset_id', 'asset.id')
            ->where('geofence.id', $geo->id)
            ->select(
                DB::raw('GROUP_CONCAT(DISTINCT asset.asset_name ORDER BY asset.id) AS assets_name'),
                'geofence.type_geo',
                'geofence.id',
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

    public function editGeofence()
    {
        $geo = Geofence::find(request('id'));
        $geo->geofence_name = request('name');
        $geo->type = request('typegeo');
        $geo->update();

        $geobinding = GeofenceBinding::where('geofence_id', request('id'))->get();
        foreach ($geobinding as $geob) {
            $geob->delete();
        }
        foreach (request('assetgeo') as $asset) {
            $device = Device::where('asset_id', $asset)->first();
            $geobinding = new GeofenceBinding;
            $geobinding->geofence_id = $geo->id;
            $geobinding->device_imei = $device->device_imei;
            $geobinding->asset_id = $asset;
            $geobinding->save();
        }

        $geod = Geofence::join('geofence_binding', 'geofence.id', 'geofence_binding.geofence_id')
            ->join('asset', 'geofence_binding.asset_id', 'asset.id')
            ->where('geofence.id', $geo->id)
            ->select(
                DB::raw('GROUP_CONCAT(DISTINCT asset.asset_name ORDER BY asset.id) AS assets_name'),
                'geofence.type_geo',
                'geofence.id',
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
        $geo = Cache::remember('geofenceee', 120, function () {
            return Geofence::join('geofence_binding', 'geofence_binding.geofence_id', 'geofence.id')
                ->join('asset', 'geofence_binding.asset_id', 'asset.id')
                ->groupBy('geofence.id')
                ->select(DB::raw('GROUP_CONCAT(DISTINCT asset.asset_name ORDER BY asset.id) AS assets_name'), 'geofence.type_geo', 'geofence.id', 'geometry', 'radius', 'type', 'geofence_name')
                ->get();
        });

        return response()->json([
            'success' => true,
            'message' => $geo,
        ], 200);
    }

    public function getgeofencebyid()
    {
        $geo = GeofenceBinding::where('geofence_id', request('id'))
            ->select('asset_id')
            ->get();

        return response()->json([
            'success' => true,
            'message' => $geo,
        ], 200);
    }

    public function deletegeofence()
    {
        $geo = Geofence::find(request('idGeo'));
        $geo->delete();
        $geoB = GeofenceBinding::where('geofence_id', request('idGeo'))->get();
        foreach ($geoB as $geoBe) {
            $geoBe->delete();
        }

        return response()->json([
            'success' => true,
            'message' => $geo,
        ], 200);
    }
}
