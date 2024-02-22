<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\AdsbDataPosition;
use App\Models\AisDataPosition;
use App\Models\AisDataVessel;
use App\Models\MapSetting;
use App\Models\RadarData;
use Carbon\Carbon;
use Illuminate\Http\Request;

class MapController extends Controller
{
    public function cekposisi()
    {
        $mmsi = request('mmsi');
        $ais_vessel = AisDataVessel::where('mmsi', $mmsi)->first();

        if ($ais_vessel) {
            $ais_position = AisDataPosition::where('vessel_id', $ais_vessel->id)->with('reportGeofences')->orderBy('created_at', 'DESC')->first();
        }

        return response()->json([
            'success' => true,
            'vessel_info' => $ais_vessel,
            'vessel_position_geofence' => $ais_position
        ], 200);
    }

    public function breadcrumb()
    {
        $map_setting = MapSetting::select('breadcrumb', 'breadcrumb_point')->first();

        if ($map_setting) {
            $trackQuery = AisDataPosition::orderBy('created_at', 'DESC')
                ->select('latitude', 'longitude', 'heading', 'vessel_id')
                ->where('vessel_id', request('vessel_id'))
                // ->groupBy('vessel_id')
                ->with('vessel', 'sensorData.sensor.datalogger')
                ->limit($map_setting->breadcrumb_point);
        } else {
            $trackQuery = AisDataPosition::orderBy('created_at', 'DESC')
                ->select('latitude', 'longitude', 'heading', 'vessel_id')
                ->where('vessel_id', request('vessel_id'))
                // ->groupBy('vessel_id')
                ->with('vessel', 'sensorData.sensor.datalogger')
                ->limit(10);
        }

        // if ($map_setting->breadcrumb === 'duration') {
        //     $trackQuery->whereNotNull('latitude')
        //         ->whereBetween('created_at', [now()->subMinutes((int)$map_setting->breadcrumb), now()]);
        // }

        $track = $trackQuery->get();

        return response()->json([
            'success' => true,
            'message' => $track,
        ], 200);
    }

    public function playback()
    {
        $date = Carbon::parse(request('dateFrom'));
        $date_until = Carbon::parse(request('dateTo'))->addDays(1);
        $selectedSensors = request('sensor');

        $mmsi = request('mmsi'); // Get the MMSI from the request
        $hexIdent = request('hex_ident'); // Get hex_ident from the request
        $targetId = request('target_id'); // Get target_id from the request
        $pelabuhanId = request('pelabuhan_id');
        $geofenceId = request('geofence_id');

        $dataAis = [];
        $dataAdsb = [];
        $dataRadar = [];
        $uniqueTimestamps = [];
        if (in_array('ais', $selectedSensors)) {
            $aisTracks = AisDataPosition::orderBy('ais_data_positions.created_at', 'ASC')
                ->join('ais_data_vessels', 'ais_data_positions.vessel_id', 'ais_data_vessels.id')
                ->leftJoin('report_geofences', 'ais_data_positions.id', '=', 'report_geofences.ais_data_position_id')
                ->leftJoin('geofences', 'report_geofences.geofence_id', '=', 'geofences.id')
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
                    'ais_data_vessels.callsign',
                    'ais_data_vessels.draught', // Add more columns as needed
                    'ais_data_vessels.reported_destination',
                    'ais_data_vessels.vessel_type',
                    'ais_data_vessels.no_pkk',
                    'report_geofences.in',
                    'report_geofences.out',
                    'report_geofences.total_time',
                    'geofences.geofence_name',
                    'geofences.id as geofence_id' // Add this line to select geofence_id
                )
                ->when($date, function ($query) use ($date, $date_until) {
                    $query->whereBetween('ais_data_positions.created_at', [$date, $date_until]);
                })
                ->when($mmsi, function ($query) use ($mmsi) {
                    $query->where('ais_data_vessels.mmsi', $mmsi);
                })
                ->get();

            foreach ($aisTracks as $track) {
                $mmsi = $track['mmsi'];
                $dataAis[$mmsi]['mmsi'] = $mmsi;
                if (!isset($dataAis[$mmsi]['playback'])) {
                    $dataAis[$mmsi]['playback'] = [];
                }
                $geofenceInfo = [];

                // Generate a unique timestamp for each entry in 'playback'
                $timestamp = Carbon::parse($track['created_at'])->timestamp;

                // Check for duplicates and skip if already processed
                if (isset($uniqueTimestamps[$timestamp])) {
                    continue;
                }

                $uniqueTimestamps[$timestamp] = true;

                // Check if the vessel is inside any geofence
                if ($track->geofence_id) {
                    $geofenceName = $track->geofence_name;

                    // Include geofence information
                    $geofenceInfo = [
                        ['key' => 'Geofence Name', 'value' => $geofenceName],
                        ['key' => 'In', 'value' => $track->in ?? null],
                        ['key' => 'Out', 'value' => $track->out ?? null],
                        ['key' => 'Total Time', 'value' => $track->total_time ?? null],
                    ];
                }
                // Access additional vessel information from AisDataVessel model
                $vesselInfo = [
                    'vesselType' => $track->vessel_type,
                    'draught' => $track->draught,
                    'reportedDestination' => $track->reported_destination,
                    'vesselName' => $track->vessel_name,
                    'imo' => $track->imo,
                    'callsign' => $track->callsign,
                    'noPKK' => $track->no_pkk
                    // Add more information as needed
                ];
                $dataAis[$mmsi]['vessel_info'] = $vesselInfo;
                $dataAis[$mmsi]['playback'][] = [
                    'lat' => (float) $track['latitude'],
                    'lng' => (float) $track['longitude'],
                    'dir' => ((int) $track['course'] * M_PI) / 180.0,
                    'time' => $timestamp,
                    'heading' => (int) $track['heading'],
                    'info' => array_merge([
                        'mmsi' => $mmsi,
                        'name' => $track['vessel_name'],
                        'imo' => $track['imo'],
                        'callsign' => $track['callsign'],
                        'sog' => $track['speed'],
                        'cog' => $track['course'],
                        'geofenceName' => $geofenceName ?? null,
                        'in' => $track->in ?? null,
                        'out' => $track->out ?? null,
                        'latitude' => $track['latitude'],
                        'longitude' => $track['longitude'],
                        'timeStamp' => Carbon::parse($track['created_at'])->format('Y-m-d H:i:s')
                    ]),
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

    public function checkplayback()
    {
        $date = Carbon::parse(request('dateFrom'));
        $date_until = Carbon::parse(request('dateTo'));
        $selectedSensors = request('sensor');

        $mmsi = request('mmsi'); // Get the MMSI from the request
        $hexIdent = request('hex_ident'); // Get hex_ident from the request
        $targetId = request('target_id'); // Get target_id from the request
        $pelabuhanId = request('pelabuhan_id');
        $geofenceId = request('geofence_id');

        $hasPlaybackData = false;
        if (in_array('ais', $selectedSensors)) {
            $aisTracksCount = AisDataPosition::orderBy('ais_data_positions.created_at', 'ASC')
                ->join('ais_data_vessels', 'ais_data_positions.vessel_id', 'ais_data_vessels.id')
                ->leftJoin('report_geofences', 'ais_data_positions.id', '=', 'report_geofences.ais_data_position_id')
                ->leftJoin('geofences', 'report_geofences.geofence_id', '=', 'geofences.id')
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
                    'ais_data_vessels.callsign',
                    'ais_data_vessels.draught', // Add more columns as needed
                    'ais_data_vessels.reported_destination',
                    'ais_data_vessels.vessel_type',
                    'ais_data_vessels.no_pkk',
                    'report_geofences.in',
                    'report_geofences.out',
                    'report_geofences.total_time',
                    'geofences.geofence_name',
                    'geofences.id as geofence_id' // Add this line to select geofence_id
                )
                ->when($date, function ($query) use ($date, $date_until) {
                    $query->whereBetween('ais_data_positions.created_at', [$date, $date_until]);
                })
                ->when($mmsi, function ($query) use ($mmsi) {
                    $query->where('ais_data_vessels.mmsi', $mmsi);
                })
                ->count();
            if ($aisTracksCount > 0) {
                $hasPlaybackData = true;
            }
        }

        if (in_array('adsb', $selectedSensors)) {

            $adsbTracksCount = AdsbDataPosition::join('adsb_data_aircrafts', 'adsb_data_positions.aircraft_id', 'adsb_data_aircrafts.id')
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
                ->count();

            if ($adsbTracksCount > 0) {
                $hasPlaybackData = true;
            }
        }

        if (in_array('radar', $selectedSensors)) {
            $radarDataTracksCount = RadarData::orderBy('created_at', 'DESC')
                ->when($date, function ($query) use ($date, $date_until) {
                    $query->whereBetween('created_at', [$date, $date_until]);
                })
                ->when($targetId, function ($query) use ($targetId) {
                    $query->where('target_id', $targetId); // Filter by target_id if provided
                })
                ->count();

            if ($radarDataTracksCount > 0) {
                $hasPlaybackData = true;
            }
        }

        $response = [
            'success' => true,
            'has_playback_data' => $hasPlaybackData,
        ];

        return response()->json($response, 200);
    }
}
