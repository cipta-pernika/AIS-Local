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
            ->select('latitude', 'longitude')
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

        $track = AisDataPosition::orderBy('ais_data_positions.created_at', 'DESC')
            ->join('ais_data_vessels', 'ais_data_positions.vessel_id', 'ais_data_vessels.id')
            ->where('ais_data_vessels.mmsi', request('mmsi'))
            ->select(
                'ais_data_positions.latitude',
                'ais_data_positions.longitude',
                'ais_data_positions.course',
                'ais_data_positions.created_at',
                'ais_data_positions.speed',
                'ais_data_vessels.mmsi',
                'ais_data_vessels.vessel_name',
                'ais_data_vessels.imo',
                'ais_data_vessels.callsign'
            )
            ->when($date, function ($query) use ($date, $date_until) {
                $query->whereBetween('ais_data_positions.created_at', [$date, $date_until]);
            })
            ->get();
        $data = [];

        foreach ($track as $i => $val) {
            $data[] = collect([
                'lat' => (float) $val['latitude'], 'lng' => (float) $val['longitude'], 'dir' => ((int) $val['cog'] * M_PI) / 180.0,
                'time' => $val['created_at']->timestamp, 'heading' => ((int) $val['cog'] * M_PI) / 180.0,
                'info' => [
                    ['key' => 'MMSI', 'value' => $val['mmsi']],
                    ['key' => 'Name', 'value' => $val['vessel_name']],
                    ['key' => 'IMO', 'value' => $val['imo']],
                    ['key' => 'Callsign', 'value' => $val['callsign']],
                    ['key' => 'SOG', 'value' => $val['sog']],
                    ['key' => 'COG', 'value' => $val['cog']],
                    ['key' => 'Latitude', 'value' => $val['latitude']],
                    ['key' => 'Longitude', 'value' => $val['longitude']],
                    ['key' => 'Time Stamp ', 'value' => Carbon::parse($val['created_at'])->format('Y-m-d H:i:s')],
                ],
            ]);
        }

        return response()->json([
            'success' => true,
            'message' => $data,
        ], 200);
    }
}
