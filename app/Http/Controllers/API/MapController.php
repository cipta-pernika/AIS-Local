<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\AisDataPosition;
use Carbon\Carbon;
use Illuminate\Http\Request;

class MapController extends Controller
{
    public function breadcrumb()
    {
        $track = AisDataPosition::orderBy('created_at', 'DESC')
            ->select('latitude', 'longitude', 'heading')
            ->where('vessel_id', request('vessel_id'))
            ->get();

        return response()->json([
            'success' => true,
            'message' => $track,
        ], 200);
    }

    public function playback()
{
    $date = Carbon::parse(request('dateFrom'));
    $date_until = Carbon::parse(request('dateTo'));

    $tracks = AisDataPosition::orderBy('ais_data_positions.created_at', 'DESC')
        ->join('ais_data_vessels', 'ais_data_positions.vessel_id', 'ais_data_vessels.id')
        ->select(
            'ais_data_vessels.mmsi',
            'ais_data_positions.latitude',
            'ais_data_positions.longitude',
            'ais_data_positions.course',
            'ais_data_positions.heading',
            'ais_data_positions.created_at',
            'ais_data_positions.speed',
            'ais_data_vessels.vessel_name',
            'ais_data_vessels.imo',
            'ais_data_vessels.callsign'
        )
        ->when($date, function ($query) use ($date, $date_until) {
            $query->whereBetween('ais_data_positions.created_at', [$date, $date_until]);
        })
        ->get();

    $data = [];

    foreach ($tracks as $track) {
        $mmsi = $track['mmsi'];
        $data[$mmsi]['mmsi'] = $mmsi;
        $data[$mmsi]['playback'][] = [
            'lat' => (float) $track['latitude'],
            'lng' => (float) $track['longitude'],
            'dir' => ((int) $track['course'] * M_PI) / 180.0,
            'time' => $track['created_at']->timestamp,
            'heading' => (int) $track['heading'],
            'info' => [
                ['key' => 'MMSI', 'value' => $mmsi],
                ['key' => 'Name', 'value' => $track['vessel_name']],
                ['key' => 'IMO', 'value' => $track['imo']],
                ['key' => 'Callsign', 'value' => $track['callsign']],
                ['key' => 'SOG', 'value' => $track['speed']],
                ['key' => 'COG', 'value' => $track['course']],
                ['key' => 'Latitude', 'value' => $track['latitude']],
                ['key' => 'Longitude', 'value' => $track['longitude']],
                ['key' => 'Time Stamp ', 'value' => Carbon::parse($track['created_at'])->format('Y-m-d H:i:s')],
            ],
        ];
    }

    $response = [
        'success' => true,
        'message' => array_values($data),
    ];

    return response()->json($response, 200);
}

}