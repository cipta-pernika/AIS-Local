<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\AdsbDataPosition;
use App\Models\AisDataPosition;
use App\Models\RadarData;
use Carbon\Carbon;
use Illuminate\Http\Request;

class MapController extends Controller
{
    public function breadcrumb()
    {
        $vessel_id = request('vessel_id'); // Get the vessel_id from the request
        $hexIdent = request('hex_ident'); // Get hex_ident from the request
        $targetId = request('target_id'); // Get target_id from the request

        if ($vessel_id) {


            $track = AisDataPosition::orderBy('created_at', 'DESC')
                ->select('latitude', 'longitude', 'heading')
                ->where('vessel_id', $vessel_id)
                ->get();
        } else if ($hexIdent) {
            $track = AdsbDataPosition::orderBy('created_at', 'DESC')
                ->join('adsb_data_aircrafts', 'adsb_data_positions.aircraft_id', 'adsb_data_aircrafts.id')
                ->select('latitude', 'longitude', 'heading')
                ->where('adsb_data_aircrafts.hex_ident', $hexIdent)
                ->get();
        } else if ($targetId) {
            $track = RadarData::orderBy('created_at', 'DESC')
                ->select('latitude', 'longitude', 'heading')
                ->where('target_id', $targetId)
                ->get();
        }

        return response()->json([
            'success' => true,
            'message' => $track,
        ], 200);
    }

    public function playback()
    {
        $date = Carbon::parse(request('dateFrom'));
        $date_until = Carbon::parse(request('dateTo'));
        $selectedSensors = request('sensor');

        $mmsi = request('mmsi'); // Get the MMSI from the request
        $hexIdent = request('hex_ident'); // Get hex_ident from the request
        $targetId = request('target_id'); // Get target_id from the request

        $dataAis = [];
        $dataAdsb = [];
        $dataRadar = [];

        if (in_array('ais', $selectedSensors)) {

            $aisTracks = AisDataPosition::orderBy('ais_data_positions.created_at', 'DESC')
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
                ->when($mmsi, function ($query) use ($mmsi) {
                    $query->where('ais_data_vessels.mmsi', $mmsi); // Filter by MMSI if provided
                })
                ->get();

            foreach ($aisTracks as $track) {
                $mmsi = $track['mmsi'];
                $dataAis[$mmsi]['mmsi'] = $mmsi;
                $dataAis[$mmsi]['playback'][] = [
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

            $dataAis = collect($dataAis)->sortByDesc(function ($item, $key) {
                return count($item['playback']);
            })->values()->all();
        }

        if (in_array('adsb', $selectedSensors)) {

            $adsbTracks = AdsbDataPosition::join('adsb_data_aircrafts', 'adsb_data_positions.aircraft_id', 'adsb_data_aircrafts.id')
                ->select(
                    'adsb_data_positions.latitude',
                    'adsb_data_positions.longitude',
                    'adsb_data_positions.heading',
                    'adsb_data_positions.created_at',
                    'adsb_data_positions.ground_speed',
                    'adsb_data_aircrafts.hex_ident',
                    'adsb_data_aircrafts.registration',
                    'adsb_data_aircrafts.callsign'
                )
                ->orderBy('created_at', 'DESC')
                ->when($date, function ($query) use ($date, $date_until) {
                    $query->whereBetween('adsb_data_positions.created_at', [$date, $date_until]);
                })
                ->when($hexIdent, function ($query) use ($hexIdent) {
                    $query->where('adsb_data_aircrafts.hex_ident', $hexIdent); // Filter by hex_ident if provided
                })
                ->get();
            foreach ($adsbTracks as $track) {
                $mmsiAdsb = $track['hex_ident'];
                $dataAdsb[$mmsiAdsb]['hex_ident'] = $mmsiAdsb;
                $dataAdsb[$mmsiAdsb]['playback'][] = [
                    'lat' => (float) $track['latitude'],
                    'lng' => (float) $track['longitude'],
                    'dir' => ((int) $track['heading'] * M_PI) / 180.0,
                    'time' => $track['created_at']->timestamp,
                    'heading' => (int) $track['heading'],
                    'info' => [
                        ['key' => 'hex_ident', 'value' => $mmsiAdsb],
                        ['key' => 'registration', 'value' => $track['registration']],
                        ['key' => 'Callsign', 'value' => $track['callsign']],
                        ['key' => 'ground_speed', 'value' => $track['ground_speed']],
                        ['key' => 'COG', 'value' => $track['heading']],
                        ['key' => 'Latitude', 'value' => $track['latitude']],
                        ['key' => 'Longitude', 'value' => $track['longitude']],
                        ['key' => 'Time Stamp ', 'value' => Carbon::parse($track['created_at'])->format('Y-m-d H:i:s')],
                    ],
                ];
            }

            $dataAdsb = collect($dataAdsb)->sortByDesc(function ($item, $key) {
                return count($item['playback']);
            })->values()->all();
        }

        if (in_array('radar', $selectedSensors)) {
            $radarDataTracks = RadarData::orderBy('created_at', 'DESC')
                ->when($date, function ($query) use ($date, $date_until) {
                    $query->whereBetween('created_at', [$date, $date_until]);
                })
                ->when($targetId, function ($query) use ($targetId) {
                    $query->where('target_id', $targetId); // Filter by target_id if provided
                })
                ->get();

            foreach ($radarDataTracks as $track) {
                $mmsiAdsb = $track['target_id'];
                $dataRadar[$mmsiAdsb]['target_id'] = $mmsiAdsb;
                $dataRadar[$mmsiAdsb]['playback'][] = [
                    'lat' => (float) $track['latitude'],
                    'lng' => (float) $track['longitude'],
                    'dir' => ((int) $track['course'] * M_PI) / 180.0,
                    'time' => $track['created_at']->timestamp,
                    'heading' => (int) $track['heading'],
                    'info' => [
                        // Info data here...
                    ],
                ];
            }

            $dataRadar = collect($dataRadar)->sortByDesc(function ($item, $key) {
                return count($item['playback']);
            })->values()->all();
        }

        $response = [
            'success' => true,
            'message' => [
                'ais' => $dataAis,
                'adsb' => $dataAdsb,
                'radardata' => $dataRadar,
            ],
        ];

        return response()->json($response, 200);
    }
}
