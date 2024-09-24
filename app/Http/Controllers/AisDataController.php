<?php

namespace App\Http\Controllers;

use App\Models\AisDataVessel;
use App\Models\VesselList20240621;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class AisDataController extends Controller
{
    public function unique()
    {
        $response = Http::get('http://127.0.0.1:9000/collections/postgisftw.latest_positions/items.json');
        $data = $response->json();

        foreach ($data['features'] as &$feature) {
            if (is_null($feature['properties']['name'])) {
                $vessel = AisDataVessel::where('mmsi', $feature['properties']['mmsi'])->first();
                if ($vessel) {
                    $feature['properties']['name'] = $vessel->vessel_name;
                } else {
                    $vessel = VesselList20240621::where('mmsi', $feature['properties']['mmsi'])->first();
                    if ($vessel) {
                        $feature['properties']['name'] = $vessel->vessel_name;
                    }
                }
            }
        }

        return response()->json($data);
    }
}
