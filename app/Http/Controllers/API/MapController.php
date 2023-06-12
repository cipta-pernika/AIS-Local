<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\AisDataPosition;
use Illuminate\Http\Request;

class MapController extends Controller
{
    public function breadcrumb()
    {
        $track = AisDataPosition::orderBy('created_at', 'DESC')
            ->select('latitude', 'longitude')
            ->where('vessel_id', request('vessel_id'))
            ->get();

        return response()->json([
            'success' => true,
            'message' => $track,
        ], 200);
    }
}
