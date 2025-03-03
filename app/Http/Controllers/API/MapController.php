<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\AdsbDataPosition;
use App\Models\AisDataPosition;
use App\Models\RadarData;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;

class MapController extends Controller
{
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

        // Create a cache key based on all parameters
        $cacheKey = "checkplayback_" . md5(json_encode([
            'dateFrom' => $date->toDateTimeString(),
            'dateTo' => $date_until->toDateTimeString(),
            'sensors' => $selectedSensors,
            'mmsi' => $mmsi,
            'hex_ident' => $hexIdent,
            'target_id' => $targetId,
            'pelabuhan_id' => $pelabuhanId,
            'geofence_id' => $geofenceId
        ]));

        // Try to get from cache first (cache for 10 minutes)
        return Cache::remember($cacheKey, 600, function () use (
            $date, $date_until, $selectedSensors, $mmsi, $hexIdent, $targetId, $pelabuhanId, $geofenceId
        ) {
            $hasPlaybackData = false;
            
            if (in_array('ais', $selectedSensors)) {
                $aisQuery = AisDataPosition::orderBy('ais_data_positions.created_at', 'ASC')
                    ->join('ais_data_vessels', 'ais_data_positions.vessel_id', 'ais_data_vessels.id')
                    ->whereBetween('ais_data_positions.created_at', [$date, $date_until]);
                
                if ($mmsi) {
                    $aisQuery->where('ais_data_vessels.mmsi', $mmsi);
                }
                
                if ($pelabuhanId) {
                    $aisQuery->where('ais_data_positions.pelabuhan_id', $pelabuhanId);
                }
                
                if ($geofenceId) {
                    $aisQuery->where('ais_data_positions.geofence_id', $geofenceId);
                }
                
                $aisTracksCount = $aisQuery->count();
                
                if ($aisTracksCount > 0) {
                    $hasPlaybackData = true;
                }
            }
            
            if (in_array('adsb', $selectedSensors) && !$hasPlaybackData) {
                $adsbQuery = AdsbDataPosition::orderBy('adsb_data_positions.created_at', 'ASC')
                    ->join('adsb_data_aircrafts', 'adsb_data_positions.aircraft_id', 'adsb_data_aircrafts.id')
                    ->whereBetween('adsb_data_positions.created_at', [$date, $date_until]);
                
                if ($hexIdent) {
                    $adsbQuery->where('adsb_data_aircrafts.hex_ident', $hexIdent);
                }
                
                if ($pelabuhanId) {
                    $adsbQuery->where('adsb_data_positions.pelabuhan_id', $pelabuhanId);
                }
                
                $adsbTracksCount = $adsbQuery->count();
                
                if ($adsbTracksCount > 0) {
                    $hasPlaybackData = true;
                }
            }
            
            if (in_array('radar', $selectedSensors) && !$hasPlaybackData) {
                $radarQuery = RadarData::orderBy('created_at', 'ASC')
                    ->whereBetween('created_at', [$date, $date_until]);
                
                if ($targetId) {
                    $radarQuery->where('target_id', $targetId);
                }
                
                if ($pelabuhanId) {
                    $radarQuery->where('pelabuhan_id', $pelabuhanId);
                }
                
                $radarTracksCount = $radarQuery->count();
                
                if ($radarTracksCount > 0) {
                    $hasPlaybackData = true;
                }
            }
            
            return response()->json([
                'success' => true,
                'has_playback_data' => $hasPlaybackData,
            ], 200);
        });
    }
    public function breadcrumb()
    {
        $vessel_id = request('vessel_id'); // Get the vessel_id from the request
        $hexIdent = request('hex_ident'); // Get hex_ident from the request
        $targetId = request('target_id'); // Get target_id from the request
        $mmsi = request('mmsi'); // Get mmsi from the request
        
        // Define cache key based on request parameters
        $cacheKey = "breadcrumb_" . ($vessel_id ?? '') . "_" . ($hexIdent ?? '') . "_" . ($targetId ?? '') . "_" . ($mmsi ?? '');
        
        // Try to get from cache first (cache for 5 minutes)
        $track = Cache::remember($cacheKey, 300, function () use ($vessel_id, $hexIdent, $targetId, $mmsi) {
            if ($vessel_id) {
                return AisDataPosition::orderBy('created_at', 'DESC')
                    ->select('latitude', 'longitude', 'heading')
                    ->where('vessel_id', $vessel_id)
                    ->limit(50)
                    ->get();
            } else if ($mmsi) {
                return AisDataPosition::orderBy('ais_data_positions.created_at', 'DESC')
                    ->join('ais_data_vessels', 'ais_data_positions.vessel_id', 'ais_data_vessels.id')
                    ->select('ais_data_positions.latitude', 'ais_data_positions.longitude', 'ais_data_positions.heading')
                    ->where('ais_data_vessels.mmsi', $mmsi)
                    ->limit(50)
                    ->get();
            } else if ($hexIdent) {
                return AdsbDataPosition::orderBy('adsb_data_positions.created_at', 'DESC')
                    ->join('adsb_data_aircrafts', 'adsb_data_positions.aircraft_id', 'adsb_data_aircrafts.id')
                    ->select('adsb_data_positions.latitude', 'adsb_data_positions.longitude', 'adsb_data_positions.heading')
                    ->where('adsb_data_aircrafts.hex_ident', $hexIdent)
                    ->limit(50)
                    ->get();
            } else if ($targetId) {
                return RadarData::orderBy('created_at', 'DESC')
                    ->select('latitude', 'longitude', 'heading')
                    ->where('target_id', $targetId)
                    ->limit(50)
                    ->get();
            }
            
            return collect(); // Return empty collection if no parameters match
        });

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

        $mmsi = request('mmsi');
        $hexIdent = request('hex_ident');
        $targetId = request('target_id');

        // Create a cache key based on request parameters
        $cacheKey = 'playback_' . md5(json_encode([
            'dateFrom' => $date->toDateTimeString(),
            'dateTo' => $date_until->toDateTimeString(),
            'sensors' => $selectedSensors,
            'mmsi' => $mmsi,
            'hex_ident' => $hexIdent,
            'target_id' => $targetId
        ]));

        // Try to get data from cache (store for 30 minutes)
        return cache()->remember($cacheKey, 30 * 60, function () use ($date, $date_until, $selectedSensors, $mmsi, $hexIdent, $targetId) {
            $dataAis = [];
            $dataAdsb = [];
            $dataRadar = [];

            if (in_array('ais', $selectedSensors)) {
                $aisTracks = AisDataPosition::select(
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
                ->join('ais_data_vessels', 'ais_data_positions.vessel_id', 'ais_data_vessels.id')
                ->whereBetween('ais_data_positions.created_at', [$date, $date_until])
                ->when($mmsi, function ($query) use ($mmsi) {
                    $query->where('ais_data_vessels.mmsi', $mmsi);
                })
                ->orderBy('ais_data_positions.created_at', 'DESC')
                ->get();

                foreach ($aisTracks as $track) {
                    $mmsi = $track['mmsi'];
                    if (!isset($dataAis[$mmsi])) {
                        $dataAis[$mmsi] = ['mmsi' => $mmsi, 'playback' => []];
                    }
                    
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

                $dataAis = collect($dataAis)->sortByDesc(function ($item) {
                    return count($item['playback']);
                })->values()->all();
            }

            if (in_array('adsb', $selectedSensors)) {
                $adsbTracks = AdsbDataPosition::select(
                    'adsb_data_positions.latitude',
                    'adsb_data_positions.longitude',
                    'adsb_data_positions.heading',
                    'adsb_data_positions.created_at',
                    'adsb_data_positions.ground_speed',
                    'adsb_data_aircrafts.hex_ident',
                    'adsb_data_aircrafts.registration',
                    'adsb_data_aircrafts.callsign'
                )
                ->join('adsb_data_aircrafts', 'adsb_data_positions.aircraft_id', 'adsb_data_aircrafts.id')
                ->whereBetween('adsb_data_positions.created_at', [$date, $date_until])
                ->when($hexIdent, function ($query) use ($hexIdent) {
                    $query->where('adsb_data_aircrafts.hex_ident', $hexIdent);
                })
                ->orderBy('adsb_data_positions.created_at', 'DESC')
                ->get();
                
                foreach ($adsbTracks as $track) {
                    $hexIdent = $track['hex_ident'];
                    if (!isset($dataAdsb[$hexIdent])) {
                        $dataAdsb[$hexIdent] = ['hex_ident' => $hexIdent, 'playback' => []];
                    }
                    
                    $dataAdsb[$hexIdent]['playback'][] = [
                        'lat' => (float) $track['latitude'],
                        'lng' => (float) $track['longitude'],
                        'dir' => ((int) $track['heading'] * M_PI) / 180.0,
                        'time' => $track['created_at']->timestamp,
                        'heading' => (int) $track['heading'],
                        'info' => [
                            ['key' => 'hex_ident', 'value' => $hexIdent],
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

                $dataAdsb = collect($dataAdsb)->sortByDesc(function ($item) {
                    return count($item['playback']);
                })->values()->all();
            }

            if (in_array('radar', $selectedSensors)) {
                $radarDataTracks = RadarData::select(
                    'target_id',
                    'latitude',
                    'longitude',
                    'course',
                    'heading',
                    'created_at',
                    'speed'
                )
                ->whereBetween('created_at', [$date, $date_until])
                ->when($targetId, function ($query) use ($targetId) {
                    $query->where('target_id', $targetId);
                })
                ->orderBy('created_at', 'DESC')
                ->get();

                foreach ($radarDataTracks as $track) {
                    $targetId = $track['target_id'];
                    if (!isset($dataRadar[$targetId])) {
                        $dataRadar[$targetId] = ['target_id' => $targetId, 'playback' => []];
                    }
                    
                    $dataRadar[$targetId]['playback'][] = [
                        'lat' => (float) $track['latitude'],
                        'lng' => (float) $track['longitude'],
                        'dir' => ((int) $track['course'] * M_PI) / 180.0,
                        'time' => $track['created_at']->timestamp,
                        'heading' => (int) $track['heading'],
                        'info' => [
                            ['key' => 'Target ID', 'value' => $targetId],
                            ['key' => 'Speed', 'value' => $track['speed']],
                            ['key' => 'Course', 'value' => $track['course']],
                            ['key' => 'Latitude', 'value' => $track['latitude']],
                            ['key' => 'Longitude', 'value' => $track['longitude']],
                            ['key' => 'Time Stamp', 'value' => Carbon::parse($track['created_at'])->format('Y-m-d H:i:s')],
                        ],
                    ];
                }

                $dataRadar = collect($dataRadar)->sortByDesc(function ($item) {
                    return count($item['playback']);
                })->values()->all();
            }

            return response()->json([
                'success' => true,
                'message' => [
                    'ais' => $dataAis,
                    'adsb' => $dataAdsb,
                    'radardata' => $dataRadar,
                ],
            ], 200);
        });
    }
}
