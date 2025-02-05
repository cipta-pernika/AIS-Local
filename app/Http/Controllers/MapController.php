<?php

namespace App\Http\Controllers;

use App\Models\AisDataPosition;
use Carbon\Carbon;
use Illuminate\Http\Request;

class MapController extends Controller
{
    public function playback()
    {
        $date = Carbon::parse(request('dateFrom'));
        $date_until = Carbon::parse(request('dateTo'));
        $date_until_when = $date->copy()->addHours(3);
        $selectedSensors = request('sensor');

        $mmsi = request('mmsi');
        $hexIdent = request('hex_ident');
        $targetId = request('target_id');
        $pelabuhanId = request('pelabuhan_id');
        $geofenceId = request('geofence_id');

        $dataAis = [];
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
                    'ais_data_vessels.mmsi',
                    'ais_data_positions.latitude',
                    'ais_data_positions.longitude',
                    'ais_data_positions.course',
                    'ais_data_positions.heading',
                    'ais_data_positions.created_at',
                    'ais_data_positions.speed',
                    'ais_data_positions.id',
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
                    'geofences.id as geofence_id',
                    'sensor_datas.id as sensor_data_id',
                    'sensors.id as sensor_id',
                    'dataloggers.id as datalogger_id'
                )
                ->when($date, function ($query) use ($date, $date_until) {
                    $query->whereBetween('ais_data_positions.created_at', [$date->startOfSecond(), $date_until->endOfSecond()]);
                })
                ->when($mmsi, function ($query) use ($mmsi) {
                    $query->where('ais_data_vessels.mmsi', $mmsi);
                })
                ->when($geofenceId, function ($query) use ($geofenceId) {
                    $query->where('geofence_id', $geofenceId);
                })
                ->when($pelabuhanId, function ($query) use ($pelabuhanId, $date, $date_until_when) {
                    $query->where('dataloggers.pelabuhan_id', $pelabuhanId)
                        ->whereBetween('ais_data_positions.created_at', [$date, $date_until_when]);
                })
                ->limit(15000)
                ->get();

            $aisTracks = $aisTracks->filter(function ($value, $key) {
                return $key % 2 == 0;
            });

            $aisTracks = $aisTracks->filter(function ($track, $key) use (&$lastTimestamp, &$aisTracks) {
                $timestamp = Carbon::parse($track->created_at)->timestamp;
                $geofence_id = $track->geofence_id;
    
                if (!isset($lastTimestamp) || ($timestamp - $lastTimestamp) >= 180) {
                    $lastTimestamp = $timestamp;
                    return true;
                }
                if ($geofence_id) {
                    return true;
                }
                 // New logic to create dummy data if timestamp > 540
                if ($timestamp > 540) {
                    for ($i = 1; $i <= 3; $i++) {
                        $dummyTimestamp = $timestamp + ($i * 180);
                        // Create dummy data here (you may need to adjust this part based on your data structure)
                        $dummyTrack = clone $track; // Clone the original track
                        $dummyTrack->created_at = Carbon::createFromTimestamp($dummyTimestamp);
                        // Add the dummy track to the aisTracks collection
                        $aisTracks->push($dummyTrack);
                    }
                }
                return false;
            });

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
                if ($track->geofence_id) {
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
                } else {
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
                            'latitude' => $track['latitude'],
                            'longitude' => $track['longitude'],
                            'timeStamp' => Carbon::parse($track['created_at'])->format('Y-m-d H:i:s')
                        ]),
                    ];
                }
            }

            $dataAis = collect($dataAis)->sortByDesc(function ($item, $key) {
                return count($item['playback']);
            })->values()->all();
        }

        $response = [
            'success' => true,
            'message' => [
                'ais' => $dataAis,
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
                    $query->whereBetween('ais_data_positions.created_at', [$date->startOfSecond(), $date_until->endOfSecond()]);
                })
                ->when($mmsi, function ($query) use ($mmsi) {
                    $query->where('ais_data_vessels.mmsi', $mmsi);
                })
                ->when($geofenceId, function ($query) use ($geofenceId) {
                    $query->where('geofence_id', $geofenceId);
                })
                ->exists();
        }

        $response = [
            'success' => true,
            'has_playback_data' => $aisTracksCount,
        ];

        return response()->json($response, 200);
    }
}
