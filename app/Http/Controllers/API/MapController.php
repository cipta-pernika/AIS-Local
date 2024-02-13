<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\AdsbDataPosition;
use App\Models\AisDataPosition;
use App\Models\MapSetting;
use App\Models\RadarData;
use Carbon\Carbon;
use Illuminate\Http\Request;

class MapController extends Controller
{
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
        $date_until = Carbon::parse(request('dateTo'));
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
                ->leftJoin('sensor_datas', 'ais_data_positions.sensor_data_id', '=', 'sensor_datas.id')
                ->leftJoin('sensors', 'sensor_datas.sensor_id', '=', 'sensors.id')
                ->leftJoin('dataloggers', 'sensors.datalogger_id', '=', 'dataloggers.id')
                ->select(
                    'ais_data_vessels.*',
                    'ais_data_positions.latitude',
                    'ais_data_positions.longitude',
                    'ais_data_positions.course',
                    'ais_data_positions.heading',
                    'ais_data_positions.sensor_data_id',
                    'ais_data_positions.created_at as position_created_at',
                    'report_geofences.in',
                    'report_geofences.out',
                    'report_geofences.total_time',
                    'geofences.geofence_name',
                    'geofences.id as geofence_id',
                    'dataloggers.pelabuhan_id' // Select all columns from dataloggers
                )
                ->when($date, function ($query) use ($date, $date_until) {
                    $query->whereBetween('ais_data_positions.created_at', [$date, $date_until]);
                })
                ->when($mmsi, function ($query) use ($mmsi) {
                    $query->where('ais_data_vessels.mmsi', $mmsi);
                })
                ->when($geofenceId, function ($query) use ($geofenceId) {
                    $query->where('geofence_id', $geofenceId);
                })
                ->when($pelabuhanId, function ($query) use ($pelabuhanId) {
                    $query->where('dataloggers.pelabuhan_id', $pelabuhanId); // Assuming pelabuhan_id is in dataloggers table
                })
                ->get();

            $dataAis = [];

            foreach ($aisTracks as $track) {
                $mmsi = $track->mmsi;
                $timestamp = Carbon::parse($track->position_created_at)->timestamp;

                if (!isset($uniqueTimestamps[$timestamp])) {
                    $uniqueTimestamps[$timestamp] = true;
                    $geofenceName = $track->geofence_id ? $track->geofence_name : null;

                    $dataAis[$mmsi]['mmsi'] = $mmsi;
                    $dataAis[$mmsi]['playback'][] = [
                        'lat' => (float) $track->latitude,
                        'lng' => (float) $track->longitude,
                        'dir' => ((int) $track->course * M_PI) / 180.0,
                        'time' => $timestamp,
                        'heading' => (int) $track->heading,
                        'mmsi' => $mmsi,
                        'vessel_name' => $track->vessel_name,
                        'imo' => $track->imo,
                        'callsign' => $track->callsign,
                        'vessel_type' => $track->vessel_type,
                        'draught' => $track->draught,
                        'reported_destination' => $track->reported_destination,
                        'no_pkk' => $track->no_pkk,
                        'geofence_name' => $geofenceName,
                        'in' => $track->in ?? null,
                        'out' => $track->out ?? null,
                        'total_time' => $track->total_time ?? null,
                    ];
                }
            }

            $dataAis = collect($dataAis)->sortByDesc(function ($item) {
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
