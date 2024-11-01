<?php

namespace App\Http\Controllers;

use App\Mail\GeofenceMail;
use App\Models\AdsbData;
use App\Models\AdsbDataAircraft;
use App\Models\AdsbDataFlight;
use App\Models\AdsbDataPosition;
use App\Models\AisDataPosition;
use App\Models\AisDataVessel;
use App\Models\Asset;
use App\Models\BongkarMuatTerlambat;
use App\Models\Datalogger;
use App\Models\DataMandiriPelaksanaanKapal;
use App\Models\EventTracking;
use App\Models\Geofence;
use App\Models\GeofenceBinding;
use App\Models\ImptPelayananKapal;
use App\Models\ImptPenggunaanAlat;
use App\Models\InaportnetBongkarMuat;
use App\Models\InaportnetPergerakanKapal;
use App\Models\PanduTerlambat;
use App\Models\PanduTidakTerjadwal;
use App\Models\PbkmKegiatanPemanduan;
use App\Models\RadarData;
use App\Models\ReportGeofence;
use App\Models\ReportGeofenceBongkarMuat;
use App\Models\Sensor;
use App\Models\SensorData;
use App\Models\TidakTerjadwal;
use App\Models\User;
use Barryvdh\DomPDF\Facade\Pdf;
use Carbon\Carbon;
use Illuminate\Contracts\Database\Eloquent\Builder;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Http;
use Location\Bearing\BearingSpherical;
use Location\Coordinate;
use Location\Distance\Haversine;
use Location\Distance\Vincenty;
use Location\Polygon;
use Filament\Notifications\Notification;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;

class HelperController extends Controller
{
    public function playback()
    {
        $source = request('source');
        $record = request('record');

        switch ($source) {
            case 'inaportnet-pergerakan-kapal':
                $inaportnet = InaportnetPergerakanKapal::find($record);
                break;
            case 'imptPenggunaanAlat':
                $inaportnet = ImptPenggunaanAlat::find($record);
                break;
            case 'impt_pelayanan_kapal':
                $inaportnet = ImptPelayananKapal::find($record);
                break;
            case 'pbkm-kegiatan-pemanduan':
                $inaportnet = PbkmKegiatanPemanduan::find($record);
                break;
            case 'report-geofence':
                $inaportnet = ReportGeofence::find($record);
                break;
            default:
                $inaportnet = InaportnetBongkarMuat::find($record);
                break;
        }

        if ($source == 'report-geofence') {
            $ais_vessel = AisDataVessel::where('mmsi', $inaportnet->mmsi)->first();
        } else {
            $ais_vessel = AisDataVessel::where('vessel_name', 'like', "%$inaportnet->nama_kapal%")->orWhere('mmsi', $inaportnet->mmsi)->first();
        }

        if ($ais_vessel) {
            $ais_position = AisDataPosition::where('vessel_id', $ais_vessel->id)->orderBy('created_at', 'DESC')->first();

            // If ais_position is found
            if ($ais_position) {
                $mmsi = $ais_vessel->mmsi;
                $startDate = Carbon::parse($ais_position->timestamp)->subDays(3)->toDateString();
                $endDate = Carbon::parse($ais_position->timestamp)->addDays(3)->toDateString();

                // Constructing the URL
                $url = "https://sopbuntutksopbjm.com/playback?type=mmsi&value=$mmsi&start_date=$startDate&end_date=$endDate&is_ais=true";
                return redirect($url);
            }

            // If ais_position is not found
            $url = "https://sopbuntutksopbjm.com/?msg=Position not found for the vessel.";
            return redirect($url);
        } else {
            // Redirect with error message
            $errorMessage = urlencode('Vessel not found in AIS data.');
            $url = "https://sopbuntutksopbjm.com/?msg=$errorMessage";
            return redirect($url);
        }
    }

    public function cekposisi()
    {
        $source = request('source');
        $record = request('record');

        switch ($source) {
            case 'inaportnet-pergerakan-kapal':
                $inaportnet = InaportnetPergerakanKapal::find($record);
                break;
            case 'imptPenggunaanAlat':
                $inaportnet = ImptPenggunaanAlat::find($record);
                break;
            case 'impt_pelayanan_kapal':
                $inaportnet = ImptPelayananKapal::find($record);
                break;
            case 'pbkm-kegiatan-pemanduan':
                $inaportnet = PbkmKegiatanPemanduan::find($record);
                break;
            default:
                $inaportnet = InaportnetBongkarMuat::find($record);
                break;
        }

        $ais_vessel = AisDataVessel::where('vessel_name', 'like', "%$inaportnet->nama_kapal%")->orWhere('mmsi', $inaportnet->mmsi)->first();

        if ($ais_vessel) {
            $ais_position = AisDataPosition::where('vessel_id', $ais_vessel->id)->first();

            // If ais_position is found
            if ($ais_position) {
                $latitude = $ais_position->latitude;
                $longitude = $ais_position->longitude;
                $timestamp = $ais_position->timestamp;

                // Redirect with latitude, longitude, and timestamp
                $url = "https://sopbuntutksopbjm.com/?lat=$latitude&lng=$longitude&timestamp=$timestamp";
                return redirect($url);
            }

            // If ais_position is not found
            $url = "https://sopbuntutksopbjm.com/?msg=Position not found for the vessel.&mmsi=$ais_vessel->mmsi";
            return redirect($url);
        } else {
            // Redirect with error message
            $errorMessage = urlencode('Vessel not found in AIS data.');
            $url = "https://sopbuntutksopbjm.com/?msg=$errorMessage";
            return redirect($url);
        }
    }


    public function redirecttoplayback()
    {
        return redirect('admin/playback');
    }

    public function eventtrackings()
    {
        // Define a unique cache key for this query
        $cacheKey = 'event_trackings_cache';

        // Check if the result is already in the cache
        if (Cache::has($cacheKey)) {
            // If cached, return the cached result
            $event = Cache::get($cacheKey);
        } else {
            // If not cached, perform the query and store the result in the cache
            $event = EventTracking::where('event_id', 9)
                ->orderBy('created_at', 'DESC')
                ->with([
                    'aisDataPosition', 
                    'aisDataPosition.vessel', 
                    'geofence', 
                    'event',
                    'aisDataPosition.reportGeofences' => function($query) {
                        $query->whereNotNull('in'); // Only include records where 'in' is not null
                    }
                ])
                ->whereNotNull('mmsi')
                ->whereNotNull('ais_data_position_id')
                ->whereHas('aisDataPosition.reportGeofences') // Only include records that have related reportGeofences
                ->limit(50)
                ->get();

            // Cache the result for 60 minutes (you can adjust the duration)
            Cache::put($cacheKey, $event, 60);
        }

        return response()->json([
            'success' => true,
            'message' => $event,
        ], 200);
    }
    
    public function search(Request $request)
    {
        $query = $request->input('query');

        // Use the search method provided by Laravel Scout
        $results = AisDataVessel::search($query)->query(fn (Builder $query) => $query->with('positions'))->get();

        return response()->json($results);
    }

    public function dailyreport()
    {
        // Create a unique cache key based on the date range
        $cacheKey = 'dailyreport_' . request('date_from') . '_' . request('date_to');

        // Attempt to retrieve the data from the cache
        $cachedData = Cache::get($cacheKey);

        if (!$cachedData) {
            // If not cached, fetch and calculate the data
            $dateFrom = Carbon::parse(request('date_from'));
            $dateTo = Carbon::parse(request('date_to'))->endOfDay();

            $jumlahkapal = AisDataVessel::whereBetween('updated_at', [$dateFrom, $dateTo])->count();
            $jumlahpesawat = AdsbDataPosition::whereBetween('updated_at', [$dateFrom, $dateTo])->count();

            $jumlahkapalByType = AisDataVessel::select('vessel_type', DB::raw('count(*) as count'))
                ->whereBetween('updated_at', [$dateFrom, $dateTo])
                ->groupBy('vessel_type')
                ->get();

            $jumlahradardata = RadarData::whereBetween('timestamp', [$dateFrom, $dateTo])->count();

            $radarImageUrl = Storage::disk('public')->url('radar/radar.png');

            // Store the calculated data in the cache for 24 hours
            Cache::put($cacheKey, [
                'jumlahkapal' => $jumlahkapal,
                'jumlahpesawat' => $jumlahpesawat,
                'jumlahkapal_by_type' => $jumlahkapalByType,
                'jumlahradardata' => $jumlahradardata,
                'radar_image_url' => $radarImageUrl,
            ], 24 * 60); // Cache for 24 hours
        } else {
            // Extract the data from the cached array
            $jumlahkapal = $cachedData['jumlahkapal'];
            $jumlahpesawat = $cachedData['jumlahpesawat'];
            $jumlahkapalByType = $cachedData['jumlahkapal_by_type'];
            $jumlahradardata = $cachedData['jumlahradardata'];
            $radarImageUrl = $cachedData['radar_image_url'];
        }

        return response()->json([
            'success' => true,
            'jumlahkapal' => $jumlahkapal,
            'jumlahpesawat' => $jumlahpesawat,
            'jumlahkapal_by_type' => $jumlahkapalByType,
            'jumlahradardata' => $jumlahradardata,
            'radar_image_url' => $radarImageUrl,
        ], 201);
    }

    public function dailyreportprint()
    {
        //http://localhost:8000/dailyreport?user_id=1&date_from=2023-07-22&date_to=2023-07-22
        $dateFrom = Carbon::parse(request('date_from'));
        $dateTo = Carbon::parse(request('date_to'))->endOfDay();

        $jumlahkapal = AisDataVessel::whereBetween('updated_at', [$dateFrom, $dateTo])->count();
        $jumlahpesawat = AdsbDataPosition::whereBetween('updated_at', [$dateFrom, $dateTo])->count();

        $jumlahkapalByType = AisDataVessel::select('vessel_type', DB::raw('count(*) as count'))
            ->whereBetween('updated_at', [$dateFrom, $dateTo])
            ->groupBy('vessel_type')
            ->get();

        $jumlahradardata = RadarData::whereBetween('timestamp', [$dateFrom, $dateTo])->count();

        $radarImageUrl = Storage::disk('public')->url('radar/radar.png');

        $pdf = Pdf::loadView('daily-report', [
            'jumlahkapal' => $jumlahkapal,
            'jumlahpesawat' => $jumlahpesawat,
            'radar_image_url' => $radarImageUrl,
            'jumlahkapalByType' => $jumlahkapalByType,
            'jumlahradardata' => $jumlahradardata,
        ]);

        return $pdf->download('daily-report.pdf');
    }

    public function datamandiripdf(Request $request)
    {
        // Manually validate request parameters
        $validator = Validator::make($request->all(), [
            'start_date' => 'required|date',
            'end_date' => 'required|date|after_or_equal:start_date',
        ]);

        // If validation fails, return error response
        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Validation failed',
                'errors' => $validator->errors(),
            ], 422);
        }

        $startDateTime = Carbon::parse($request->start_date)->startOfDay();
        $endDateTime = Carbon::parse($request->end_date)->endOfDay();


        // Retrieve data based on the provided start and end dates
        $summaryData = DataMandiriPelaksanaanKapal::whereBetween(DB::raw('DATE(created_at)'), [$startDateTime, $endDateTime])
            ->selectRaw('
        SUM(CASE WHEN isPassing = 1 THEN 1 ELSE 0 END) AS passing_count,
        SUM(CASE WHEN isPandu = 1 THEN 1 ELSE 0 END) AS pandu_count,
        SUM(CASE WHEN isBongkarMuat = 1 THEN 1 ELSE 0 END) AS bongkar_muat_count
    ')->whereNotNull('pnbp_jasa_labuh_kapal')
            ->first();

        $total_data_mandiri_ais = ReportGeofenceBongkarMuat::whereBetween(DB::raw('DATE(created_at)'), [$startDateTime, $endDateTime])->count();
        $total_data_inaportnet = InaportnetBongkarMuat::whereBetween(DB::raw('DATE(created_at)'), [$startDateTime, $endDateTime])->count();
        $total_tidak_terjadwal_bongkar = TidakTerjadwal::whereBetween(DB::raw('DATE(created_at)'), [$startDateTime, $endDateTime])->where('isPassing', 0)->count();
        $total_pandu_tidak_tejadwal = PanduTidakTerjadwal::whereBetween(DB::raw('DATE(created_at)'), [$startDateTime, $endDateTime])->where('isPassing', 0)->count();
        $total_late_bongkar = BongkarMuatTerlambat::whereBetween(DB::raw('DATE(created_at)'), [$startDateTime, $endDateTime])->count();
        $total_late_pandu = PanduTerlambat::whereBetween(DB::raw('DATE(created_at)'), [$startDateTime, $endDateTime])->count();
        $total_pandu = $summaryData['pandu_count'] + $total_pandu_tidak_tejadwal;
        $total_muat = $summaryData['bongkar_muat_count'] + $total_tidak_terjadwal_bongkar;

        // Calculate total kapal
        $total_kapal = $summaryData['passing_count'] + $total_pandu + $total_muat;

        // Modify the structure of the summary data
        $summaryData['pandu_count'] = [
            'total' => $total_pandu,
            'detail' => [
                'valid' => $summaryData['pandu_count'],
                'tidak_terjadwal' => $total_pandu_tidak_tejadwal,
                'terlambat' => $total_late_pandu
            ]
        ];

        $summaryData['bongkar_muat_count'] = [
            'total' => $total_muat,
            'detail' => [
                'valid' => $summaryData['bongkar_muat_count'],
                'tidak_terjadwal' => $total_tidak_terjadwal_bongkar,
                'terlambat' => $total_late_bongkar
            ]
        ];

        // If validation fails, return error response
        $perPage = $request->get('limit', 10);

        if ($request->has('search')) {
            $searchTerm = $request->input('search');

            $allAddons = DataMandiriPelaksanaanKapal::whereHas('aisDataVessel', function ($query) use ($searchTerm) {
                $query->where('vessel_name', 'like', '%' . $searchTerm . '%');
            })->get();
        } else {
            $allAddons = DataMandiriPelaksanaanKapal::all();
        }

        // Manually paginate the results
        $addons = $allAddons->slice(
            $request->get('skip', 0),
            $perPage
        )->values(); // Reset keys to start from 0

        $addons->load([
            'aisDataVessel', 'aisDataPosition', 'geofence', 'imptPelayananKapal', 'imptPenggunaanAlat', 'reportGeofence',
            'inaportnetBongkarMuat', 'pbkmKegiatanPemanduan'
        ]);

        // dd($addons);

        $pdf = Pdf::loadView('pdf.datamandiripdf', [
            'summaryData' => $summaryData,
            'addons' => $addons,
            'total_kapal' => $total_kapal,
        ])->setPaper('a3', 'landscape');

        return $pdf->download('daily-report.pdf');
    }

    public function updateradarname()
    {
        $id = request('id');
        $name = request('name');

        if (is_null($name)) {
            return response()->json([
                'success' => false,
                'message' => 'Name cannot be null.',
            ], 400);
        }

        $radarData = RadarData::find($id);
        if (!$radarData) {
            return response()->json([
                'success' => false,
                'message' => 'RadarData not found.',
            ], 404);
        }

        $radarData->name = $name;
        $radarData->update();

        $aisData = RadarData::with('sensorData.sensor.datalogger')
            ->groupBy('target_id')
            // ->whereBetween('created_at', [now()->subHours(120), now()])
            ->limit(30)
            ->get();

        return response()->json([
            'success' => true,
            'message' => $aisData,
        ], 200);
    }

    public function radarpng()
    {
        $image = request()->file('file');
        $image->move(public_path() . '/radarfolder', $image->getClientOriginalName());
        return response()->json([
            'success' => true,
        ], 200);
    }

    public function position()
    {
        $datalogger = Datalogger::find(1);
        $datalogger->latitude = request('lat');
        $datalogger->longitude = request('lon');
        $datalogger->update();

        return response()->json([
            'success' => true,
            'message' => $datalogger,
        ], 201);
    }

    public function movebylatlng()
    {
        $datalogger = Datalogger::find(1);
        $pointA = new Coordinate($datalogger->latitude, $datalogger->longitude);
        $pointB = new Coordinate(request('lat'), request('lng'));
        $bearingCalculator = new BearingSpherical();
        $distance = number_format($pointA->getDistance($pointB, new Vincenty()), 0, 0, 0) * 1;
        $bearing = number_format($bearingCalculator->calculateBearing($pointA, $pointB), 0, '', '') * 10;
        $c = sqrt(pow(10, 2) + pow($distance, 2));
        $angleA = rad2deg(asin(10 / $c));
        $angleB = rad2deg(asin($distance / $c));
        $tilt = number_format($angleA, 0, '', '') * 10;
        $zoom = mt_rand(25, 35);

        $xml_data = '<PTZData version="2.0" xmlns="http://www.isapi.org/ver20/XMLSchema">
        <AbsoluteHigh>
        <elevation>' . $tilt . ' </elevation>
        <azimuth>' . ($bearing) . ' </azimuth>
        <absoluteZoom>' . $zoom . ' </absoluteZoom>
        </AbsoluteHigh>
        </PTZData>';

        $url = 'http://admin:Amtek2024@10.7.0.8:8080/PTZCtrl/channels/1/absolute';
        $ch = curl_init($url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'PUT');
        curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: text/xml'));
        curl_setopt($ch, CURLOPT_POSTFIELDS, "$xml_data");
        $result = curl_exec($ch);
        curl_close($ch);

        return response()->json([
            'msg' => $result,
            'bea' => $bearing,
            'beacukai' => (3600 - $bearing),
            'success' => true,
            "tilt" => $tilt,
            "distance" => $distance,
            "c" => $c,
            "angle A" => $angleA,
            "angle B" => $angleB,
            "xml req" => $xml_data,
        ], 200);
    }

    public function detailvessel()
    {
        $vesselId = AisDataVessel::where('mmsi', request('mmsi'))->first();

        $aisData = AisDataPosition::where('vessel_id', $vesselId->id)
            ->with('vessel', 'sensorData.sensor.datalogger')
            ->latest()
            ->first();

        return response()->json([
            'success' => true,
            'message' => $aisData,
        ], 201);
    }

    public function mylocation()
    {
        $vesselId = Datalogger::select('latitude', 'longitude')->first();

        return response()->json([
            'success' => true,
            'message' => $vesselId,
        ], 201);
    }

    public function isValidLatitude($latitude)
    {
        return ($latitude >= -90 && $latitude <= 90);
    }

    public function isValidLongitude($longitude)
    {
        return ($longitude >= -180 && $longitude <= 180);
    }

    public function aisdata()
    {
        $url = app()->isLocal()
            ? 'http://localhost:8000/sendgeofencealarmksop'
            : 'https://nr.monitormyvessel.com/sendgeofencealarmksop';
        if (empty(request()->source)) {
            return response()->json([
                'error' => 'No request payload provided.',
            ], 400);
        }

        $sensor = Sensor::find(1);

        $sensorData = new SensorData([
            'sensor_id' => $sensor->id,
            'payload' => request()->source,
            'timestamp' => Carbon::parse(request()->isoDate),
        ]);
        $sensorData->save();

        $vesselPosition = null;

        if (request()->mmsi) {
            $vessel = AisDataVessel::updateOrCreate(['mmsi' => request()->mmsi]);
            if ($vessel->wasRecentlyCreated) {
                // EventTracking::create([
                //     'event_id' => 6,
                //     'mmsi' => request()->mmsi,
                // ]);
            }

            $latitude = request()->latitude;
            $longitude = request()->longitude;
            if ($this->isValidLatitude($latitude) && $this->isValidLongitude($longitude)) {
                $datalogger = Datalogger::find(1);
                $coordinate1 = new Coordinate($datalogger->latitude, $datalogger->longitude);
                $coordinate2 = new Coordinate(request()->latitude, request()->longitude);
                $distance = $coordinate1->getDistance($coordinate2, new Haversine());
                $distanceInKilometers = $distance / 1000;
                $distanceInNauticalMiles = $distanceInKilometers * 0.539957;
                $vesselPosition = new AisDataPosition([
                    'sensor_data_id' => $sensorData->id,
                    'vessel_id' => $vessel->id,
                    'latitude' => request()->latitude,
                    'longitude' => request()->longitude,
                    'speed' => request()->speedOverGround,
                    'course' => request()->courseOverGround,
                    'heading' => request()->trueHeading,
                    'navigation_status' => request()->navigationStatus,
                    'turning_rate' => request()->turningRate ?? request()->rateOfTurn,
                    'turning_direction' => request()->turningDirection,
                    'timestamp' => Carbon::parse(request()->isoDate),
                    'distance' => $distanceInNauticalMiles,
                ]);
                $vesselPosition->save();
            }
        } else if (request()->senderMmsi) {
            $vessel = AisDataVessel::updateOrCreate([
                'mmsi' => request()->senderMmsi,
            ], [
                'vessel_name' => request('name'),
                'vessel_type' => request('shipType_text'),
                'imo' => request('shipId'),
                'callsign' => request('callsign'),
                'draught' => request('draught'),
                'reported_destination' => request('destination'),
                'dimension_to_bow' => request('dimensionToBow'),
                'dimension_to_stern' => request('dimensionToStern'),
                'dimension_to_port' => request('dimensionToPort'),
                'dimension_to_starboard' => request('dimensionToStarboard'),
                'reported_eta' => Carbon::parse(request('eta')),
                'type_number' => request('type_number'),
            ]);
            $asset = Asset::updateOrCreate(
                ['mmsi' => request()->mmsi],
                [
                    'asset_name' => request('name'),
                    'imo' => request('shipId'),
                    'callsign' => request('callsign'),
                ]
            );
            if ($vessel->wasRecentlyCreated) {
                // EventTracking::create([
                //     'event_id' => 6,
                //     'mmsi' => request()->mmsi,
                //     'ship_name' => request('name')
                // ]);
            }
        }

        $aisData = null;

        if ($vesselPosition) {
            $aisData = AisDataPosition::with('vessel', 'sensorData.sensor.datalogger')
                ->orderBy('created_at', 'DESC')
                ->groupBy('vessel_id')
                ->where('id', $vesselPosition->id)
                ->first();
        }

        //data mandiri
        try {
            $today = Carbon::today();
            $dataMandiri = DataMandiriPelaksanaanKapal::where('ais_data_vessel_id', $vessel->id)
                ->whereDate('created_at', $today)
                ->first();

            // If no data found for today, create new entry
            if (!$dataMandiri) {
                // Create new entry for today
                $dataMandiri = new DataMandiriPelaksanaanKapal();
                $dataMandiri->ais_data_vessel_id = $vessel->id;
                // Set other attributes if needed
                $dataMandiri->save();
            }
        } catch (\Exception $e) {
            // Handle exception
            // For example: Log the exception
            Log::error('Error occurred while retrieving or creating data: ' . $e->getMessage());
        }

        try {
            //detect inside geofence
            $geofenceDatas = Geofence::all();
            foreach ($geofenceDatas as $value) {
                if ($value->geometry) {
                    $geoParse = json_decode($value->geometry);

                    if ($geoParse && $value->type_geo === 'circle') {
                        $jarak = $this->distance(
                            request()->latitude,
                            request()->longitude,
                            $geoParse->geometry->coordinates[1],
                            $geoParse->geometry->coordinates[0],
                            'K'
                        );
                        if ($jarak <= (float) $value['radius'] / 1000) {
                            if ($value['type'] === 'in' || $value['type'] === 'both') {
                                // Mail::to('support@pernika.com')->send(new GeofenceMail([
                                //     'asset' => $asset,
                                //     'geofence' => $value
                                // ]));
                                EventTracking::create([
                                    'event_id' => 9,
                                    'ais_data_position_id' => $aisData->id,
                                    'mmsi' => $aisData->vessel->mmsi,
                                    'geofence_id' => $value['id']
                                ]);
                                $aisData->is_inside_geofence = 1;
                                $aisData->update();

                                Http::post($url, [
                                    'msg' => $aisData->vessel->vessel_name . ' Inside ' . $value['geofence_name'] . ' Geofence', 'type' => 'notif'
                                ]);
                                try {
                                    $recipient = User::first();

                                    Notification::make()
                                        ->title($aisData->vessel->vessel_name . ' Inside ' . $value['geofence_name'] . ' Geofence')
                                        ->sendToDatabase($recipient);
                                } catch (\Exception $e) {
                                }
                            }
                            $existingReport = ReportGeofence::where('geofence_id', $value['id'])
                                ->where('mmsi', $aisData->vessel->mmsi)
                                ->orderBy('in', 'desc')
                                ->first();
                            if (!$existingReport || $existingReport->in->diffInHours(Carbon::parse($aisData->timestamp)) > 5) {
                                ReportGeofence::updateOrCreate(
                                    [
                                        'ais_data_position_id' => $aisData->id,
                                    ],
                                    [
                                        'event_id' => 9,
                                        'geofence_id' => $value['id'],
                                        'mmsi' => $aisData->vessel->mmsi,
                                        'in' => Carbon::parse($aisData->timestamp)
                                    ]
                                );
                            }
                        } else {
                            if ($value['type'] === 'out' || $value['type'] === 'both') {
                                // Mail::to('support@pernika.com')->send(new GeofenceMail([
                                //     'asset' => $asset,
                                //     'geofence' => $value
                                // ]));
                                $washere = EventTracking::where('mmsi', $aisData->vessel->mmsi)
                                    ->where('event_id', 9)->where('geofence_id', $value['id'])->first();
                                if ($washere) {
                                    EventTracking::create([
                                        'event_id' => 10,
                                        'ais_data_position_id' => $aisData->id,
                                        'mmsi' => $aisData->vessel->mmsi,
                                        'geofence_id' => $value['id']
                                    ]);
                                    Http::post($url, [
                                        'msg' => $aisData->vessel->vessel_name . ' Outside ' . $value['geofence_name'] . ' Geofence', 'type' => 'notif'
                                    ]);
                                    try {
                                        $recipient = User::first();

                                        Notification::make()
                                            ->title($aisData->vessel->vessel_name . ' Outside ' . $value['geofence_name'] . ' Geofence')
                                            ->sendToDatabase($recipient);
                                    } catch (\Exception $e) {
                                    }
                                }
                            }
                            $washere = EventTracking::where('mmsi', $aisData->vessel->mmsi)
                                ->where('event_id', 9)->where('geofence_id', $value['id'])->first();
                            if ($washere) {
                                $existingReport = ReportGeofence::where('mmsi', $aisData->vessel->mmsi)
                                    ->where('geofence_id', $value['id'])
                                    ->whereNull('out')
                                    ->whereNotNull('in')
                                    ->first();

                                if ($existingReport) {
                                    $existingReport->update([
                                        'out' => Carbon::parse($aisData->timestamp),
                                        'total_time' => $existingReport->in->diffInMinutes($aisData->timestamp)
                                    ]);
                                }
                            }
                        }
                    } else if ($geoParse && ($value->type_geo === 'polygon' || $value->type_geo === 'rectangle')) {
                        // Handle polygon or rectangle case
                        $geofence = new Polygon();
                        foreach ($geoParse as $valGeo) {
                            $geofence->addPoint(new Coordinate($valGeo[0], $valGeo[1]));
                        }
                        $insidePoint = new Coordinate(request()->latitude,  request()->longitude);
                        if ($geofence->contains($insidePoint)) {
                            if ($value['type'] === 'in' || $value['type'] === 'both') {
                                // Mail::to('support@pernika.com')->send(new GeofenceMail([
                                //     'asset' => $asset,
                                //     'geofence' => $value
                                // ]));
                                EventTracking::create([
                                    'event_id' => 9,
                                    'ais_data_position_id' => $aisData->id,
                                    'mmsi' => $aisData->vessel->mmsi,
                                    'geofence_id' => $value['id']
                                ]);
                                $aisData->is_inside_geofence = 1;
                                $aisData->update();
                                Http::post($url, [
                                    'msg' => $aisData->vessel->vessel_name . ' Inside ' . $value['geofence_name'] . ' Geofence', 'type' => 'notif'
                                ]);
                                try {
                                    $recipient = User::first();

                                    Notification::make()
                                        ->title($aisData->vessel->vessel_name . ' Inside ' . $value['geofence_name'] . ' Geofence')
                                        ->sendToDatabase($recipient);
                                } catch (\Exception $e) {
                                }
                            }
                            $existingReport = ReportGeofence::where('geofence_id', $value['id'])
                                ->where('mmsi', $aisData->vessel->mmsi)
                                ->orderBy('in', 'desc')
                                ->first();
                            if ($existingReport->in->diffInHours(Carbon::parse($aisData->timestamp)) > 5) {
                                ReportGeofence::updateOrCreate(
                                    [
                                        'ais_data_position_id' => $aisData->id,
                                    ],
                                    [
                                        'event_id' => 9,
                                        'geofence_id' => $value['id'],
                                        'mmsi' => $aisData->vessel->mmsi,
                                        'in' => Carbon::parse($aisData->timestamp)
                                    ]
                                );
                            }
                            if ($existingReport->isEmpty()) {
                                ReportGeofence::updateOrCreate(
                                    [
                                        'ais_data_position_id' => $aisData->id,
                                    ],
                                    [
                                        'event_id' => 9,
                                        'geofence_id' => $value['id'],
                                        'mmsi' => $aisData->vessel->mmsi,
                                        'in' => Carbon::parse($aisData->timestamp)
                                    ]
                                );
                            }
                        } else {
                            if ($value['type'] === 'out' || $value['type'] === 'both') {
                                // Mail::to('support@pernika.com')->send(new GeofenceMail([
                                //     'asset' => $asset,
                                //     'geofence' => $value
                                // ]));
                                $washere = EventTracking::where('mmsi', $aisData->vessel->mmsi)
                                    ->where('event_id', 9)->where('geofence_id', $value['id'])->first();
                                if ($washere) {
                                    EventTracking::create([
                                        'event_id' => 10,
                                        'ais_data_position_id' => $aisData->id,
                                        'mmsi' => $aisData->vessel->mmsi,
                                        'geofence_id' => $value['id']
                                    ]);
                                    Http::post($url, [
                                        'msg' => $aisData->vessel->vessel_name . ' Outside ' . $value['geofence_name'] . ' Geofence', 'type' => 'notif'
                                    ]);
                                    try {
                                        $recipient = User::first();

                                        Notification::make()
                                            ->title($aisData->vessel->vessel_name . ' Outside ' . $value['geofence_name'] . ' Geofence')
                                            ->sendToDatabase($recipient);
                                    } catch (\Exception $e) {
                                    }
                                }
                            }
                            $washere = EventTracking::where('mmsi', $aisData->vessel->mmsi)
                                ->where('event_id', 9)->where('geofence_id', $value['id'])->first();
                            if ($washere) {
                                $existingReport = ReportGeofence::where('mmsi', $aisData->vessel->mmsi)
                                    ->where('geofence_id', $value['id'])
                                    ->whereNull('out')
                                    ->whereNotNull('in')
                                    ->first();

                                if ($existingReport) {
                                    $existingReport->update([
                                        'out' => Carbon::parse($aisData->timestamp),
                                        'total_time' => $existingReport->in->diffInMinutes($aisData->timestamp)
                                    ]);
                                }
                            }
                        }
                    } else {
                        // Handle other cases
                        $isInside = [];
                    }
                }
            }
        } catch (\Exception $e) {
        }

        return response()->json([
            'aisData' => $aisData,
            // 'sensor' => $sensor,
            // 'sensorData' => $sensorData,
            // 'vessel' => $vessel ?? null,
            // 'vesselPosition' => $vesselPosition ?? null,
        ], 201);
    }

    public function distance($lat1, $lon1, $lat2, $lon2, $unit)
    {
        if (($lat1 == $lat2) && ($lon1 == $lon2)) {
            return 0;
        } else {
            $theta = $lon1 - $lon2;
            $dist = sin(deg2rad($lat1)) * sin(deg2rad($lat2)) + cos(deg2rad($lat1)) * cos(deg2rad($lat2)) * cos(deg2rad($theta));
            $dist = acos($dist);
            $dist = rad2deg($dist);
            $miles = $dist * 60 * 1.1515;
            $unit = strtoupper($unit);

            if ($unit == "K") {
                return ($miles * 1.609344);
            } else if ($unit == "N") {
                return ($miles * 0.8684);
            } else {
                return $miles;
            }
        }
    }

    public function aisstatic()
    {

        $vessel = AisDataVessel::updateOrCreate([
            'mmsi' => request()->senderMmsi,
        ], [
            'vessel_name' => request('name'),
            'vessel_type' => request('shipType_text'),
            'imo' => request('shipId'),
            'callsign' => request('callsign'),
            'draught' => request('draught'),
            'reported_destination' => request('destination'),
            'dimension_to_bow' => request('dimensionToBow'),
            'dimension_to_stern' => request('dimensionToStern'),
            'dimension_to_port' => request('dimensionToPort'),
            'dimension_to_starboard' => request('dimensionToStarboard'),
            'reported_eta' => Carbon::parse(request('eta')),
        ]);

        $asset = Asset::updateOrCreate(
            ['mmsi' => request()->mmsi],
            [
                'asset_name' => request('name'),
                'imo' => request('shipId'),
                'callsign' => request('callsign'),
            ]
        );

        return response()->json([
            'vessel' => $vessel ?? null,
        ], 201);
    }

    public function aisdatastatic()
    {

        $vessel = AisDataVessel::updateOrCreate([
            'mmsi' => request()->mmsi,
        ], [
            'vessel_name' => request('vessel_name'),
            'vessel_type' => request('vessel_type'),
            'imo' => request('imo'),
            'callsign' => request('callsign'),
            'draught' => request('draught'),
            'reported_destination' => request('reported_destination'),
            'dimension_to_bow' => request('dimension_to_bow'),
            'dimension_to_stern' => request('dimension_to_stern'),
            'dimension_to_port' => request('dimension_to_port'),
            'dimension_to_starboard' => request('dimension_to_starboard'),
            'reported_eta' => Carbon::parse(request('reported_eta')),
        ]);

        $asset = Asset::updateOrCreate(
            ['mmsi' => request()->mmsi],
            [
                'asset_name' => request('name'),
                'imo' => request('shipId'),
                'callsign' => request('callsign'),
            ]
        );

        return response()->json([
            'vessel' => $vessel ?? null,
        ], 201);
    }

    public function getaisdata()
    {
        $aisData = AisDataPosition::with('vessel', 'sensorData.sensor.datalogger')->get();

        return response()->json([
            'success' => true,
            'message' => $aisData,
        ], 201);
    }

    public function aisdataunique()
    {
        // Define a unique cache key for this query
        $cacheKey = 'ais_data_unique_cache';

        // Check if the result is already in the cache
        if (Cache::has($cacheKey)) {
            // If cached, return the cached result
            $aisData = Cache::get($cacheKey);
        } else {
            // If not cached, perform the query and store the result in the cache
            $query = AisDataPosition::with('vessel', 'sensorData.sensor.datalogger', 'anomalies')
                ->orderBy('created_at', 'DESC')
                ->groupBy('vessel_id')
                ->whereBetween('created_at', [now()->subMinutes(60), now()]);

            // Check if datalogger_id is provided in the request
            if (request()->has('datalogger_id')) {
                $query->whereHas('sensorData.sensor.datalogger', function ($subquery) {
                    $subquery->where('id', request()->datalogger_id);
                });
            }

            // $aisData = $query->get();
            
            $aisData = $query->get();
            // Tambahkan hardcode status AIS ke setiap item dalam koleksi
            // $aisData->each(function ($item) {
            //     $item->ais_status = 'On';
            // });

            Cache::put($cacheKey, $aisData, 10);
        }

        return response()->json([
            'success' => true,
            'message' => $aisData,
            // 'ais_status' => 'On',
        ], 201);
    }

    public function aisdatauniquefe()
    {
        $aisData = AisDataPosition::with('vessel', 'sensorData.sensor.datalogger')
            ->orderBy('created_at', 'DESC')
            ->groupBy('vessel_id')
            ->whereBetween('created_at', [now()->subHours(1), now()])
            ->get();

        // Tambahkan hardcode status AIS ke setiap item dalam koleksi
        // $aisData->each(function ($item) {
        //     $item->ais_status = 'On';
        // });
        return response()->json([
            'success' => true,
            'message' => $aisData,
            // 'ais_status' => 'On',
        ], 201);
    }

    public function aisdataupdate()
    {
        $aisData = AisDataPosition::with('vessel', 'sensorData.sensor.datalogger')
            ->orderBy('created_at', 'DESC')
            ->groupBy('vessel_id')
            ->whereBetween('created_at', [now()->subMinutes(10), now()])
            ->limit(100)
            ->get();

        return response()->json([
            'success' => true,
            'message' => $aisData,
        ], 201);
    }

    public function aisdatalist()
    {
        // Create a descriptive cache key
        $cacheKey = 'aisdatalist_grouped_vessels';

        // Attempt to retrieve data from the cache
        $cachedData = Cache::get($cacheKey);

        if (!$cachedData) {
            // If not cached, fetch and process the data
            $aisData = AisDataPosition::with(['vessel', 'sensorData.sensor.datalogger'])
                ->orderBy('created_at', 'DESC')
                ->select('vessel_id', 'latitude', 'longitude', 'speed', 'course', 'heading', 'navigation_status', 'timestamp', 'id')
                ->get()
                ->groupBy('vessel_id')
                ->map(function ($groupedData) {
                    $firstData = $groupedData->first();
                    $vesselData = $firstData->vessel;

                    return array_merge(
                        $vesselData->only(['mmsi', 'imo', 'vessel_name']),
                        $firstData->only(['latitude', 'longitude', 'speed', 'course', 'heading', 'navigation_status', 'timestamp', 'id'])
                    );
                })
                ->values()
                ->toArray();

            Cache::put($cacheKey, $aisData, 5);
        } else {
            // Data is already cached
            $aisData = $cachedData;
        }

        return response()->json([
            'success' => true,
            'message' => $aisData,
        ], 201);
    }

    public function adsbdatalist()
    {
        return Cache::remember('adsbdatalist_cache', now()->addMinutes(60), function () {
            $aisData = AdsbDataPosition::with('aircraft', 'sensorData.sensor.datalogger')
                ->orderBy('created_at', 'DESC')
                ->limit(200)
                ->get();

            return response()->json([
                'success' => true,
                'message' => $aisData,
            ], 201);
        });
    }

    public function radardatalist()
    {
        $aisData = RadarData::with('sensorData.sensor.datalogger')
            ->orderBy('created_at', 'DESC')
            ->get();

        return response()->json([
            'success' => true,
            'message' => $aisData,
        ], 201);
    }

    public function livefeed()
    {
        // Create a meaningful cache key
        $cacheKey = 'livefeed_data';

        // Attempt to retrieve data from the cache
        $cachedData = Cache::get($cacheKey);

        if (!$cachedData) {
            // If not cached, fetch the data
            $aisData = AisDataPosition::with('vessel')
                ->groupBy('vessel_id')
                ->limit(50)
                ->orderBy('created_at', 'DESC')
                ->get();

            $adsb = AdsbDataPosition::with('aircraft')
                ->groupBy('aircraft_id')
                ->limit(50)
                ->orderBy('created_at', 'DESC')
                ->get();

            // Store the data in the cache for a short duration
            Cache::put($cacheKey, [
                'aisData' => $aisData,
                'adsb' => $adsb,
            ], 500); // Cache for 5 minutes
        } else {
            // Extract data from the cached array
            $aisData = $cachedData['aisData'];
            $adsb = $cachedData['adsb'];
        }

        return response()->json([
            'success' => true,
            'message' => $aisData,
            'liveadsb' => $adsb,
        ], 201);
    }

    public function adsbunique()
    {
        $aisData = AdsbDataPosition::with('aircraft', 'sensorData.sensor.datalogger')
            ->whereRaw('adsb_data_positions.id IN (select MAX(adsb_data_positions.id) FROM adsb_data_positions GROUP BY aircraft_id)')
            // ->groupBy('aircraft_id')
            ->whereBetween('created_at', [now()->subHours(3), now()])
            ->orderBy('created_at', 'DESC')
            ->limit(500)
            ->get();

        return response()->json([
            'success' => true,
            'message' => $aisData,
        ], 201);
    }

    public function adsbuniquefe()
    {
        $aisData = AdsbDataPosition::with('aircraft', 'sensorData.sensor.datalogger')
            ->whereRaw('adsb_data_positions.id IN (select MAX(adsb_data_positions.id) FROM adsb_data_positions GROUP BY aircraft_id)')
            // ->groupBy('aircraft_id')
            ->whereBetween('created_at', [now()->subHours(3), now()])
            ->orderBy('created_at', 'DESC')
            ->get();

        return response()->json([
            'success' => true,
            'message' => $aisData,
        ], 201);
    }

    public function adsbupdate()
    {
        $aisData = AdsbDataPosition::with('aircraft', 'sensorData.sensor.datalogger')
            // ->groupBy('aircraft_id')
            ->whereRaw('adsb_data_positions.id IN (select MAX(adsb_data_positions.id) FROM adsb_data_positions GROUP BY aircraft_id)')
            ->whereBetween('updated_at', [now()->subMinutes(2), now()])
            ->orderBy('updated_at', 'DESC')
            ->limit(20)
            ->get();

        return response()->json([
            'success' => true,
            'message' => $aisData,
        ], 201);
    }

    public function radardataunique()
    {
        $aisData = RadarData::with('sensorData.sensor.datalogger')
            ->groupBy('target_id')
            ->whereBetween('updated_at', [now()->subMinutes(20), now()])
            ->orderBy('updated_at', 'DESC')
            ->get();

        return response()->json([
            'success' => true,
            'message' => $aisData,
        ], 201);
    }

    public function radardatauniquefe()
    {
        $aisData = RadarData::with('sensorData.sensor.datalogger')
            ->groupBy('target_id')
            ->whereBetween('created_at', [now()->subHours(1), now()])
            ->orderBy('created_at', 'DESC')
            ->limit(30)
            ->get();

        return response()->json([
            'success' => true,
            'message' => $aisData,
        ], 201);
    }

    public function radardataupdate()
    {
        // Define a unique cache key for this query
        $cacheKey = 'radar_data_update_cache';

        // Check if the result is already in the cache
        if (Cache::has($cacheKey)) {
            // If cached, return the cached result
            $aisData = Cache::get($cacheKey);
        } else {
            // If not cached, perform the query and store the result in the cache
            $aisData = RadarData::with('sensorData.sensor.datalogger')
                ->groupBy('target_id')
                ->whereBetween('created_at', [now()->subMinutes(3), now()])
                ->limit(10)
                ->get();

            Cache::put($cacheKey, $aisData, 1);
        }

        return response()->json([
            'success' => true,
            'message' => $aisData,
        ], 201);
    }

    public function radardatauniquelimit()
    {
        $aisData = RadarData::with('sensorData.sensor.datalogger')
            ->groupBy('target_id')
            ->limit(20)
            ->orderBy('created_at', 'DESC')
            ->get();

        return response()->json([
            'success' => true,
            'message' => $aisData,
        ], 201);
    }

    public function playbackais()
    {
        $aisData = AisDataPosition::with('vessel', 'sensorData.sensor.datalogger')
            ->groupBy('vessel_id')
            ->get();

        return response()->json([
            'success' => true,
            'message' => $aisData,
        ], 201);
    }

    public function adsbdata()
    {
        if (empty(request()->all())) {
            return response()->json([
                'error' => 'No request payload provided.',
            ], 400);
        }

        $sensor = Sensor::find(3);

        foreach (request('aircraft') as $key => $item) {

            $sensorData = new SensorData([
                'sensor_id' => $sensor->id,
                'payload' => $item->hex,
                'timestamp' => Carbon::parse(request('now')),
            ]);
            $sensorData->save();

            if ($item->flight) {
                $vessel = AisDataVessel::updateOrCreate(['mmsi' => request()->mmsi]);

                $latitude = request()->latitude;
                $longitude = request()->longitude;
                if ($this->isValidLatitude($latitude) && $this->isValidLongitude($longitude)) {
                    $vesselPosition = new AisDataPosition([
                        'sensor_data_id' => $sensorData->id,
                        'vessel_id' => $vessel->id,
                        'latitude' => request()->latitude,
                        'longitude' => request()->longitude,
                        'speed' => request()->speedOverGround,
                        'course' => request()->courseOverGround,
                        'heading' => request()->trueHeading,
                        'navigation_status' => request()->navigationStatus,
                        'turning_rate' => request()->turningRate ?? request()->rateOfTurn,
                        'turning_direction' => request()->turningDirection,
                        'timestamp' => Carbon::parse(request()->isoDate),
                    ]);
                    $vesselPosition->save();
                }
            } else if (request()->senderMmsi) {
                $vessel = AisDataVessel::updateOrCreate([
                    'mmsi' => request()->senderMmsi,
                ], [
                    'vessel_name' => request('name'),
                    'vessel_type' => request('shipType_text'),
                    'imo' => request('shipId'),
                    'callsign' => request('callsign'),
                    'draught' => request('draught'),
                    'reported_destination' => request('destination'),
                    'dimension_to_bow' => request('dimensionToBow'),
                    'dimension_to_stern' => request('dimensionToStern'),
                    'dimension_to_port' => request('dimensionToPort'),
                    'dimension_to_starboard' => request('dimensionToStarboard'),
                    'reported_eta' => Carbon::parse(request('eta')),
                ]);
            }
        }

        return response()->json([
            'sensor' => $sensor,
            'sensorData' => $sensorData,
            'vessel' => $vessel ?? null,
            'vesselPosition' => $vesselPosition ?? null,
        ], 201);
    }

    public function adsbdatav2()
    {
        if (empty(request()->all())) {
            return response()->json([
                'error' => 'No request payload provided.',
            ], 400);
        }

        $sensor = Sensor::find(3);

        $sensorData = new SensorData([
            'sensor_id' => $sensor->id,
            'payload' => request()->msgSbs,
            'timestamp' => Carbon::parse(request('generated_date') . ' ' . request('generated_time')),
        ]);
        $sensorData->save();

        if (request()->hex_ident) {
            $vessel = AdsbDataAircraft::updateOrCreate(
                ['hex_ident' => request()->hex_ident],
                ['callsign' => request()->callsign]
            );

            $flight = AdsbDataFlight::updateOrCreate(['flight_number' => request()->flight_id]);

            $latitude = request()->lat;
            $longitude = request()->lon;
            if ($this->isValidLatitude($latitude) && $this->isValidLongitude($longitude)) {
                $heading = '';
                $speed = 0;
                $curr = AdsbDataPosition::where('aircraft_id', $vessel->id)->latest('id')->first();
                if ($curr) {
                    $pointA = new Coordinate($curr['latitude'], $curr['longitude']);
                    $pointB = new Coordinate($latitude, $longitude);
                    $bearingCalculator = new BearingSpherical();
                    $heading = number_format($bearingCalculator->calculateBearing($pointA, $pointB), 0, '', '');

                    $timeA = Carbon::parse($curr['created_at']);
                    $timeB = Carbon::now();
                    $distance = number_format($pointA->getDistance($pointB, new Vincenty()), 0, 0, 0) / 1000;
                    $speedOnMPH = $distance / $timeA->floatDiffInHours($timeB);
                    if ($speedOnMPH >= 250) {
                        $speedOnMPH = 0;
                    }
                    $speed = str_replace(',', '', number_format($speedOnMPH / 1.852, 2));
                }
                $vesselPosition = new AdsbDataPosition([
                    'sensor_data_id' => $sensorData->id,
                    'aircraft_id' => $vessel->id,
                    'flight_id' => $flight->id,
                    'latitude' => $latitude,
                    'longitude' => $longitude,
                    'heading' => $heading,
                    'altitude' => request()->altitude,
                    'ground_speed' => request()->ground_speed ?? $speed,
                    'vertical_rate' => request()->vertical_rate,
                    'track' => request()->track,
                    // 'timestamp' => Carbon::parse(request('generated_date') . ' ' . request('generated_time')),
                    'timestamp' => Carbon::now(),
                    'transmission_type' => request()->transmission_type,
                ]);
                $vesselPosition->save();
            }
        }

        return response()->json([
            'sensor' => $sensor,
            'sensorData' => $sensorData,
            'vessel' => $vessel ?? null,
            'vesselPosition' => $vesselPosition ?? null,
        ], 201);
    }

    public function camzoomminus()
    {
        //http://admin:Amtek2024@192.168.164.100:8080/Streaming/Channels/1/picture
        $xml_data = '<PTZData version="2.0" xmlns="http://www.isapi.org/ver20/XMLSchema">' .
            '<zoom>-10</zoom>' .
            '<Momentary>' .
            '<duration> 1000 </duration>' .
            '</Momentary>' .
            '</PTZData>';

        $url = 'http://admin:Amtek2024@10.7.0.8:8080/PTZCtrl/channels/1/momentary';
        $ch = curl_init($url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'PUT');
        curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: text/xml'));
        curl_setopt($ch, CURLOPT_POSTFIELDS, "$xml_data");
        curl_exec($ch);
        curl_close($ch);

        return response()->json([
            'success' => true,
        ], 200);
    }

    public function camzoomminuscon()
    {
        $xml_data = '<PTZData version="2.0" xmlns="http://www.isapi.org/ver20/XMLSchema">' .
            '<zoom>-10</zoom>' .
            '</PTZData>';

        $url = 'http://admin:Amtek2024@10.7.0.8:8080/PTZCtrl/channels/1/continuous';
        $ch = curl_init($url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'PUT');
        curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: text/xml'));
        curl_setopt($ch, CURLOPT_POSTFIELDS, "$xml_data");
        curl_exec($ch);
        curl_close($ch);

        return response()->json([
            'success' => true,
        ], 200);
    }

    public function camstopzoom()
    {
        $xml_data = '<PTZData version="2.0" xmlns="http://www.isapi.org/ver20/XMLSchema">' .
            '<zoom>0</zoom>' .
            '</PTZData>';

        $url = 'http://admin:Amtek2024@10.7.0.8:8080/PTZCtrl/channels/1/momentary';
        $ch = curl_init($url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'PUT');
        curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: text/xml'));
        curl_setopt($ch, CURLOPT_POSTFIELDS, "$xml_data");
        curl_exec($ch);
        curl_close($ch);

        return response()->json([
            'success' => true,
        ], 200);
    }

    public function camup()
    {
        $xml_data = '<PTZData version="2.0" xmlns="http://www.isapi.org/ver20/XMLSchema">' .
            '<tilt> 20 </tilt>' .
            '<Momentary>' .
            '<duration> 1000 </duration>' .
            '</Momentary>' .
            '</PTZData>';

        $url = 'http://admin:Amtek2024@10.7.0.8:8080/PTZCtrl/channels/1/momentary';
        $ch = curl_init($url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'PUT');
        curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: text/xml'));
        curl_setopt($ch, CURLOPT_POSTFIELDS, "$xml_data");
        curl_exec($ch);
        curl_close($ch);

        return response()->json([
            'success' => true,
        ], 200);
    }

    public function camupcon()
    {
        $xml_data = '<PTZData version="2.0" xmlns="http://www.isapi.org/ver20/XMLSchema">' .
            '<tilt> 20 </tilt>' .
            '</PTZData>';

        $url = 'http://admin:Amtek2024@10.7.0.8:8080/PTZCtrl/channels/1/continuous';
        $ch = curl_init($url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'PUT');
        curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: text/xml'));
        curl_setopt($ch, CURLOPT_POSTFIELDS, "$xml_data");
        curl_exec($ch);
        curl_close($ch);

        return response()->json([
            'success' => true,
        ], 200);
    }

    public function camzoomplus()
    {
        $xml_data = '<PTZData version="2.0" xmlns="http://www.isapi.org/ver20/XMLSchema">' .
            '<zoom>10</zoom>' .
            '<Momentary>' .
            '<duration> 1000 </duration>' .
            '</Momentary>' .
            '</PTZData>';

        $url = 'http://admin:Amtek2024@10.7.0.8:8080/PTZCtrl/channels/1/momentary';
        $ch = curl_init($url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'PUT');
        curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: text/xml'));
        curl_setopt($ch, CURLOPT_POSTFIELDS, "$xml_data");
        curl_exec($ch);
        curl_close($ch);

        return response()->json([
            'success' => true,
        ], 200);
    }

    public function camzoompluscon()
    {
        $xml_data = '<PTZData version="2.0" xmlns="http://www.isapi.org/ver20/XMLSchema">' .
            '<zoom>10</zoom>' .
            '</PTZData>';

        $url = 'http://admin:Amtek2024@10.7.0.8:8080/PTZCtrl/channels/1/continuous';
        $ch = curl_init($url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'PUT');
        curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: text/xml'));
        curl_setopt($ch, CURLOPT_POSTFIELDS, "$xml_data");
        curl_exec($ch);
        curl_close($ch);

        return response()->json([
            'success' => true,
        ], 200);
    }

    public function camleft()
    {
        $xml_data = '<PTZData version="2.0" xmlns="http://www.isapi.org/ver20/XMLSchema">' .
            '<pan> -20 </pan>' .
            '<Momentary>' .
            '<duration> 1000 </duration>' .
            '</Momentary>' .
            '</PTZData>';

        $url = 'http://admin:Amtek2024@10.7.0.8:8080/PTZCtrl/channels/1/momentary';
        $ch = curl_init($url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'PUT');
        curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: text/xml'));
        curl_setopt($ch, CURLOPT_POSTFIELDS, "$xml_data");
        curl_exec($ch);
        curl_close($ch);
        return response()->json([
            'success' => true,
        ], 200);
    }

    public function camleftcon()
    {
        $xml_data = '<PTZData version="2.0" xmlns="http://www.isapi.org/ver20/XMLSchema">' .
            '<pan> -20 </pan>' .
            '</PTZData>';

        $url = 'http://admin:Amtek2024@10.7.0.8:8080/PTZCtrl/channels/1/continuous';
        $ch = curl_init($url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'PUT');
        curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: text/xml'));
        curl_setopt($ch, CURLOPT_POSTFIELDS, "$xml_data");
        curl_exec($ch);
        curl_close($ch);
        return response()->json([
            'success' => true,
        ], 200);
    }

    public function camleftup()
    {
        $xml_data = '<PTZData>' .
            '<pan>-60</pan>' .
            '<tilt>60</tilt>' .
            '</PTZData>';

        $url = 'http://admin:Amtek2024@10.7.0.8:8080/PTZCtrl/channels/1/continuous';
        $ch = curl_init($url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'PUT');
        curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: text/xml'));
        curl_setopt($ch, CURLOPT_POSTFIELDS, "$xml_data");
        curl_exec($ch);
        curl_close($ch);
        return response()->json([
            'success' => true,
        ], 200);
    }

    public function camleftupcon()
    {
        $xml_data = '<PTZData>' .
            '<pan>-60</pan>' .
            '<tilt>60</tilt>' .
            '</PTZData>';

        $url = 'http://admin:Amtek2024@10.7.0.8:8080/PTZCtrl/channels/1/continuous';
        $ch = curl_init($url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'PUT');
        curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: text/xml'));
        curl_setopt($ch, CURLOPT_POSTFIELDS, "$xml_data");
        curl_exec($ch);
        curl_close($ch);
        return response()->json([
            'success' => true,
        ], 200);
    }

    public function camstop()
    {
        $xml_data = '<PTZData version="2.0" xmlns="http://www.isapi.org/ver20/XMLSchema">' .
            '<pan> 0 </pan>' .
            '<tilt> 0 </tilt>' .
            '</PTZData>';

        $url = 'http://admin:Amtek2024@10.7.0.8:8080/PTZCtrl/channels/1/continuous';
        $ch = curl_init($url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'PUT');
        curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: text/xml'));
        curl_setopt($ch, CURLOPT_POSTFIELDS, "$xml_data");
        curl_exec($ch);
        curl_close($ch);
        return response()->json([
            'success' => true,
        ], 200);
    }

    public function camright()
    {
        $xml_data = '<PTZData version="2.0" xmlns="http://www.isapi.org/ver20/XMLSchema">' .
            '<pan> 20 </pan>' .
            '<Momentary>' .
            '<duration> 1000 </duration>' .
            '</Momentary>' .
            '</PTZData>';

        $url = 'http://admin:Amtek2024@10.7.0.8:8080/PTZCtrl/channels/1/momentary';
        $ch = curl_init($url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'PUT');
        curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: text/xml'));
        curl_setopt($ch, CURLOPT_POSTFIELDS, "$xml_data");
        curl_exec($ch);
        curl_close($ch);
        return response()->json([
            'success' => true,
        ], 200);
    }

    public function camrightup()
    {
        $xml_data = '<PTZData>' .
            '<pan>60</pan>' .
            '<tilt>60</tilt>' .
            '</PTZData>';

        $url = 'http://admin:Amtek2024@10.7.0.8:8080/PTZCtrl/channels/1/continuous';
        $ch = curl_init($url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'PUT');
        curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: text/xml'));
        curl_setopt($ch, CURLOPT_POSTFIELDS, "$xml_data");
        curl_exec($ch);
        curl_close($ch);
        return response()->json([
            'success' => true,
        ], 200);
    }

    public function camrightdown()
    {
        $xml_data = '<PTZData>' .
            '<pan>60</pan>' .
            '<tilt>-60</tilt>' .
            '</PTZData>';

        $url = 'http://admin:Amtek2024@10.7.0.8:8080/PTZCtrl/channels/1/continuous';
        $ch = curl_init($url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'PUT');
        curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: text/xml'));
        curl_setopt($ch, CURLOPT_POSTFIELDS, "$xml_data");
        curl_exec($ch);
        curl_close($ch);
        return response()->json([
            'success' => true,
        ], 200);
    }

    public function camdown()
    {
        $xml_data = '<PTZData version="2.0" xmlns="http://www.isapi.org/ver20/XMLSchema">' .
            '<tilt> -20 </tilt>' .
            '<Momentary>' .
            '<duration> 1000 </duration>' .
            '</Momentary>' .
            '</PTZData>';

        $url = 'http://admin:Amtek2024@10.7.0.8:8080/PTZCtrl/channels/1/momentary';
        $ch = curl_init($url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'PUT');
        curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: text/xml'));
        curl_setopt($ch, CURLOPT_POSTFIELDS, "$xml_data");
        curl_exec($ch);
        curl_close($ch);
        return response()->json([
            'success' => true,
        ], 200);
    }

    public function camautopan()
    {
        $xml_data = '<autoPanData>' .
            '<autoPan>1</autoPan>' .
            '</autoPanData>';

        $url = 'http://admin:Amtek2024@10.7.0.8:8080/ISAPI/PTZCtrl/channels/1/autoPan';
        $ch = curl_init($url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'PUT');
        curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: text/xml'));
        curl_setopt($ch, CURLOPT_POSTFIELDS, "$xml_data");
        curl_exec($ch);
        curl_close($ch);
        return response()->json([
            'success' => true,
        ], 200);
    }

    public function camautopanstop()
    {
        $xml_data = '<autoPanData>' .
            '<autoPan>0</autoPan>' .
            '</autoPanData>';

        $url = 'http://admin:Amtek2024@10.7.0.8:8080/ISAPI/PTZCtrl/channels/1/autoPan';
        $ch = curl_init($url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'PUT');
        curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: text/xml'));
        curl_setopt($ch, CURLOPT_POSTFIELDS, "$xml_data");
        curl_exec($ch);
        curl_close($ch);
        return response()->json([
            'success' => true,
        ], 200);
    }

    public function camfocusmin()
    {
        $xml_data = '<FocusData>' .
            '<focus>-60</focus>' .
            '</FocusData>';

        $url = 'http://admin:Amtek2024@10.7.0.8:8080/ISAPI/System/Video/inputs/channels/1/focus';
        $ch = curl_init($url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'PUT');
        curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: text/xml'));
        curl_setopt($ch, CURLOPT_POSTFIELDS, "$xml_data");
        curl_exec($ch);
        curl_close($ch);
        return response()->json([
            'success' => true,
        ], 200);
    }

    public function camfocusplus()
    {
        $xml_data = '<FocusData>' .
            '<focus>60</focus>' .
            '</FocusData>';

        $url = 'http://admin:Amtek2024@10.7.0.8:8080/ISAPI/System/Video/inputs/channels/1/focus';
        $ch = curl_init($url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'PUT');
        curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: text/xml'));
        curl_setopt($ch, CURLOPT_POSTFIELDS, "$xml_data");
        curl_exec($ch);
        curl_close($ch);
        return response()->json([
            'success' => true,
        ], 200);
    }

    public function camfocusstop()
    {
        $xml_data = '<FocusData>' .
            '<focus>0</focus>' .
            '</FocusData>';

        $url = 'http://admin:Amtek2024@10.7.0.8:8080/ISAPI/System/Video/inputs/channels/1/focus';
        $ch = curl_init($url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'PUT');
        curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: text/xml'));
        curl_setopt($ch, CURLOPT_POSTFIELDS, "$xml_data");
        curl_exec($ch);
        curl_close($ch);
        return response()->json([
            'success' => true,
        ], 200);
    }

    public function camleftdown()
    {
        $xml_data = '<PTZData>' .
            '<pan>-60</pan>' .
            '<tilt>-60</tilt>' .
            '</PTZData>';

        $url = 'http://admin:Amtek2024@10.7.0.8:8080/ISAPI/PTZCtrl/channels/1/continuous';
        $ch = curl_init($url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'PUT');
        curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: text/xml'));
        curl_setopt($ch, CURLOPT_POSTFIELDS, "$xml_data");
        curl_exec($ch);
        curl_close($ch);
        return response()->json([
            'success' => true,
        ], 200);
    }

    public function camcall()
    {
        $url = 'http://admin:Amtek2024@10.7.0.8:8080/ISAPI/PTZCtrl/channels/1/homePosition/goto';

        // The request body is empty, as specified in the cURL command
        $xml_data = '';

        $ch = curl_init($url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'PUT');
        curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: text/xml'));

        curl_setopt($ch, CURLOPT_POSTFIELDS, $xml_data);

        // Execute cURL request
        curl_exec($ch);
        $http_code = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        curl_close($ch);

        if ($http_code === 200) {
            return response()->json([
                'success' => true,
            ], 200);
        } else {
            return response()->json([
                'success' => false,
                'message' => 'Request failed with status code: ' . $http_code,
            ], $http_code);
        }
    }

    public function camset()
    {
        $url = 'http://admin:Amtek2024@10.7.0.8:8080/ISAPI/PTZCtrl/channels/1/homePosition';
        $ch = curl_init($url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'PUT');
        curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: text/xml'));

        curl_setopt($ch, CURLOPT_POSTFIELDS, '');

        curl_exec($ch);
        $http_code = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        curl_close($ch);

        if ($http_code === 200) {
            $headers = [
                'Accept' => '*/*',
                'Accept-Language' => 'en-US,en;q=0.9,id-ID;q=0.8,id;q=0.7',
                'Cache-Control' => 'max-age=0',
                'Connection' => 'keep-alive',
                'Content-Length' => '0',
                'Cookie' => '_wnd_size_mode=4; username=admin; language=en; WebSession_5e54a95ca3=ff4fafcf48d1d595b3ad2dbdbddc0986f85016dccecf0d63be477f5990fa7880; sdMarkTab_1_0=0%3AsettingBasic; sdMarkTab_2_0=0%3AbasicTcpIp; sdMarkTab_4=2%3AdisplayParamSwitch; sdMarkMenu=5%3AptzCfg; szLastPageName=ptzCfg; sdMarkTab_5=2%3AptzCfgHomePos',
                'If-Modified-Since' => '0',
                'Origin' => 'http://192.168.164.100:8080',
                'Referer' => 'http://192.168.164.100:8080/doc/page/config.asp',
                'User-Agent' => 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/122.0.0.0 Safari/537.36',
                'X-Requested-With' => 'XMLHttpRequest',
            ];

            // Make the PUT request
            $response = Http::withHeaders($headers)
                ->put('http://admin:Amtek2024@192.168.164.100:8080/ISAPI/PTZCtrl/channels/1/homePosition');


            return response()->json([
                'success' => true,
            ], 200);
        } else {
            return response()->json([
                'success' => false,
                'message' => 'Request failed with status code: ' . $http_code,
            ], $http_code);
        }
    }

    public function camirismin()
    {
        $xml_data = '<IrisData>' .
            '<iris>-60</iris>' .
            '</IrisData>';

        $url = 'http://admin:Amtek2024@10.7.0.8:8080/ISAPI/System/Video/inputs/channels/1/iris';
        $ch = curl_init($url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'PUT');
        curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: text/xml'));
        curl_setopt($ch, CURLOPT_POSTFIELDS, "$xml_data");
        curl_exec($ch);
        curl_close($ch);
        return response()->json([
            'success' => true,
        ], 200);
    }

    public function camirisplus()
    {
        $xml_data = '<IrisData>' .
            '<iris>-60</iris>' .
            '</IrisData>';

        $url = 'http://admin:Amtek2024@10.7.0.8:8080/ISAPI/System/Video/inputs/channels/1/iris';
        $ch = curl_init($url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'PUT');
        curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: text/xml'));
        curl_setopt($ch, CURLOPT_POSTFIELDS, "$xml_data");
        curl_exec($ch);
        curl_close($ch);
        return response()->json([
            'success' => true,
        ], 200);
    }

    public function camirisstop()
    {
        $xml_data = '<IrisData>' .
            '<iris>0</iris>' .
            '</IrisData>';

        $url = 'http://admin:Amtek2024@10.7.0.8:8080/ISAPI/System/Video/inputs/channels/1/iris';
        $ch = curl_init($url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'PUT');
        curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: text/xml'));
        curl_setopt($ch, CURLOPT_POSTFIELDS, "$xml_data");
        curl_exec($ch);
        curl_close($ch);
        return response()->json([
            'success' => true,
        ], 200);
    }

    public function camwiper()
    {
        $xml_data = '<PTZAux>' .
            '<id>1</id>' .
            '<type>WIPER</type>' .
            '<status>on</status>' .
            '</PTZAux>';

        $url = 'http://admin:Amtek2024@10.7.0.8:8080/ISAPI/PTZCtrl/channels/1/auxcontrols/1';
        $ch = curl_init($url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'PUT');
        curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: text/xml'));
        curl_setopt($ch, CURLOPT_POSTFIELDS, "$xml_data");
        curl_exec($ch);
        curl_close($ch);
        return response()->json([
            'success' => true,
        ], 200);
    }

    public function camstopwiper()
    {
        $xml_data = '<PTZAux>' .
            '<id>1</id>' .
            '<type>WIPER</type>' .
            '<status>off</status>' .
            '</PTZAux>';

        $url = 'http://admin:Amtek2024@10.7.0.8:8080/ISAPI/PTZCtrl/channels/1/auxcontrols/1';
        $ch = curl_init($url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'PUT');
        curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: text/xml'));
        curl_setopt($ch, CURLOPT_POSTFIELDS, "$xml_data");
        curl_exec($ch);
        curl_close($ch);
        return response()->json([
            'success' => true,
        ], 200);
    }

    public function cammenu()
    {
        $url = 'http://admin:Amtek2024@10.7.0.8:8080/ISAPI/PTZCtrl/channels/1/presets/95/goto';
        $ch = curl_init($url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'PUT');
        curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: text/xml'));
        curl_exec($ch);
        curl_close($ch);
        return response()->json([
            'success' => true,
        ], 200);
    }

    public function radardata()
    {
        if (empty(request())) {
            return response()->json([
                'error' => 'No request payload provided.',
            ], 400);
        }

        $datalogger = Datalogger::find(1);
        $coordinate1 = new Coordinate($datalogger->latitude, $datalogger->longitude);
        $coordinate2 = new Coordinate(request()->latitude, request()->longitude);
        $distance = $coordinate1->getDistance($coordinate2, new Haversine());
        $distanceInKilometers = $distance / 1000;
        $distanceInNauticalMiles = $distanceInKilometers * 0.539957;

        $radarData = new RadarData([
            'target_id' => request()->target_id,
            'latitude' => request()->latitude,
            'longitude' => request()->longitude,
            'altitude' => request()->altitude,
            'speed' => request()->speed,
            'heading' => request()->heading,
            'course' => request()->course,
            'range' => request()->range,
            'bearing' => request()->bearing,
            'timestamp' => request()->timestamp,
            'distance_from_fak' => $distanceInNauticalMiles,
        ]);
        $radarData->save();

        return response()->json([
            'radarData' => $radarData ?? null,
        ], 201);
    }

    public function radardataspx()
    {
        try {
            // Fetch radar data from the external source
            $contents = @file_get_contents('http://127.0.0.1:8160/tracks.json');

            if ($contents === false) {
                throw new \Exception('Failed to fetch radar data. Check the external source.');
            }

            $data = json_decode($contents);

            // Fetch Datalogger for reference
            $datalogger = Datalogger::find(1);
            if ($datalogger->latitude !== null && $datalogger->longitude !== null) {
                $coordinate1 = new Coordinate($datalogger->latitude, $datalogger->longitude);
            } else {
                // Handle the case where latitude or longitude is null
                // You may throw an exception, log a message, or take appropriate action.
                throw new \Exception('Latitude or longitude is null');
            }


            // Iterate through radar data features
            foreach ($data->features as $feature) {
                $properties = $feature->properties;
                $geometry = $feature->geometry->coordinates;
                // Calculate distance between two coordinates
                // Calculate distance between two coordinates
                if ($geometry[1] !== null && $geometry[0] !== null) {
                    $coordinate2 = new Coordinate($geometry[1], $geometry[0]);
                    $distance = $coordinate1->getDistance($coordinate2, new Haversine());
                    $distanceInKilometers = $distance / 1000;
                    $distanceInNauticalMiles = $distanceInKilometers * 0.539957;

                    // Rest of your code that uses $distanceInNauticalMiles...
                } else {
                    // Handle the case where latitude or longitude in $geometry is null
                    // You may throw an exception, log a message, or take appropriate action.
                    throw new \Exception('Latitude or longitude in $geometry is null');
                }


                // Update or create RadarData
                $radarData = RadarData::updateOrCreate(
                    ['target_id' => $properties->name],
                    [
                        'latitude' => $geometry[1],
                        'longitude' => $geometry[0],
                        'altitude' => $properties->altitude,
                        'speed' => $properties->speed,
                        'course' => $properties->course,
                        'heading' => $properties->heading,
                        'range' => $properties->range,
                        'bearing' => $properties->bearing,
                        'timestamp' => Carbon::now(),
                        'distance_from_fak' => $distanceInNauticalMiles
                    ]
                );
                // dd($radarData->target_id);

                $defaultValue = env('APP_ENV_CHECK', 'local');
                $urlradardatamateng = $defaultValue == 'local'
                    ? 'http://localhost:1880/radardatamateng'
                    : 'https://nr.monitormyvessel.com/radardatamateng';
                Http::post($urlradardatamateng, [
                    'target_id' => $properties->name,
                    'latitude' => $geometry[1],
                    'longitude' => $geometry[0],
                    'altitude' => $properties->altitude,
                    'speed' => $properties->speed,
                    'course' => $properties->course,
                    'heading' => $properties->heading,
                    'range' => $properties->range,
                    'bearing' => $properties->bearing,
                    'timestamp' => Carbon::now(),
                    'distance_from_fak' => $distanceInNauticalMiles,
                ]);

                $url = $defaultValue == 'local'
                    ? 'http://localhost:1880/sendgeofencealarmgmk'
                    : 'https://nr.monitormyvessel.com/sendgeofencealarm';
                $geofenceDatas = Geofence::all();
                foreach ($geofenceDatas as $value) {
                    if ($value->geometry) {
                        $geoParse = json_decode($value->geometry);

                        if ($geoParse && $value->type_geo === 'circle') {
                            $jarak = $this->distance(
                                request()->latitude,
                                request()->longitude,
                                $geoParse->geometry->coordinates[1],
                                $geoParse->geometry->coordinates[0],
                                'K'
                            );
                            if ($jarak <= (float) $value['radius'] / 1000) {
                                if ($value['type'] === 'in' || $value['type'] === 'both') {
                                    $lastEventTimestamp = EventTracking::where('target_id', $radarData->target_id)
                                        ->where('geofence_id', $value['id'])
                                        ->whereDate('created_at', Carbon::today())
                                        ->value('created_at');

                                    // If no event recorded today, create a new event
                                    if (!$lastEventTimestamp || Carbon::parse($lastEventTimestamp)->diffInHours($radarData->timestamp) > 5) {
                                        EventTracking::create([
                                            'event_id' => 9,
                                            'target_id' => $radarData->target_id,
                                            'geofence_id' => $value['id']
                                        ]);
                                        $radarData->is_inside_geofence = 1;
                                        $radarData->update();

                                        try {
                                            Http::post($url, [
                                                'msg' => $radarData->target_id . ' Inside ' . $value['geofence_name'] . ' Geofence ~ Speed  ' . $radarData->speed, 'type' => 'notif'
                                            ]);
                                        } catch (\Exception $e) {
                                            // Handle the exception here, you can log it or take appropriate action
                                            // For example:
                                            // Log::error('HTTP POST failed: ' . $e->getMessage());
                                        }
                                        try {
                                            $recipient = User::first();

                                            Notification::make()
                                                ->title($radarData->target_id . ' Inside ' . $value['geofence_name'] . ' Geofence ~ Speed  ' . $radarData->speed)
                                                ->sendToDatabase($recipient);
                                        } catch (\Exception $e) {
                                        }
                                    }
                                }
                                $existingReport = ReportGeofence::where('geofence_id', $value['id'])
                                    ->where('target_id', $radarData->target_id)
                                    ->orderBy('in', 'desc')
                                    ->first();
                                if (!$existingReport || $existingReport->in->diffInHours(Carbon::parse($radarData->timestamp)) > 5) {
                                    ReportGeofence::updateOrCreate(
                                        [
                                            'target_id' => $radarData->target_id,
                                        ],
                                        [
                                            'event_id' => 9,
                                            'geofence_id' => $value['id'],
                                            'in' => Carbon::parse($radarData->timestamp)
                                        ]
                                    );
                                }
                            } else {
                                $washere = EventTracking::where('target_id', $radarData->target_id)
                                    ->where('event_id', 9)->where('geofence_id', $value['id'])->first();
                                if ($washere) {
                                    $existingReport = ReportGeofence::where('target_id', $radarData->target_id)
                                        ->where('geofence_id', $value['id'])
                                        ->whereNull('out')
                                        ->whereNotNull('in')
                                        ->first();

                                    if ($existingReport) {
                                        $existingReport->update([
                                            'out' => Carbon::parse($radarData->timestamp),
                                            'total_time' => $existingReport->in->diffInMinutes($radarData->timestamp)
                                        ]);
                                        EventTracking::create([
                                            'event_id' => 10,
                                            'target_id' => $radarData->target_id,
                                            'geofence_id' => $value['id']
                                        ]);

                                        $message = $radarData->target_id . ' Outside ' . $value['geofence_name'] . ' Geofence ~ Speed  ' . $radarData->speed;
                                        try {
                                            Http::post($url, ['msg' => $message, 'type' => 'notif']);
                                        } catch (\Exception $e) {
                                        }
                                        try {
                                            $recipient = User::first();

                                            Notification::make()
                                                ->title($message)
                                                ->sendToDatabase($recipient);
                                        } catch (\Exception $e) {
                                        }
                                    }
                                }
                            }
                        } else if ($geoParse && ($value->type_geo === 'polygon' || $value->type_geo === 'rectangle')) {
                            // Handle polygon or rectangle case
                            $geofence = new Polygon();
                            foreach ($geoParse as $valGeo) {
                                $geofence->addPoint(new Coordinate($valGeo[0], $valGeo[1]));
                            }
                            $insidePoint = new Coordinate($geometry[1], $geometry[0]);
                            if ($geofence->contains($insidePoint)) {
                                if ($value['type'] === 'in' || $value['type'] === 'both') {
                                    $lastEventTimestamp = EventTracking::where('target_id', $radarData->target_id)
                                        ->where('geofence_id', $value['id'])
                                        ->whereDate('created_at', Carbon::today())
                                        ->value('created_at');

                                    // If no event recorded today, create a new event
                                    if (!$lastEventTimestamp || Carbon::parse($lastEventTimestamp)->diffInHours($radarData->timestamp) > 5) {
                                        EventTracking::create([
                                            'event_id' => 9,
                                            'target_id' => $radarData->target_id,
                                            'geofence_id' => $value['id']
                                        ]);
                                        $radarData->is_inside_geofence = 1;
                                        $radarData->update();
                                        try {
                                            Http::post($url, [
                                                'msg' => $radarData->target_id . ' Inside ' . $value['geofence_name'] . ' Geofence ~ Speed  ' . $radarData->speed, 'type' => 'notif'
                                            ]);
                                        } catch (\Exception $e) {
                                        }
                                        try {
                                            $recipient = User::first();

                                            Notification::make()
                                                ->title($radarData->target_id . ' Inside ' . $value['geofence_name'] . ' Geofence ~ Speed  ' . $radarData->speed)
                                                ->sendToDatabase($recipient);
                                        } catch (\Exception $e) {
                                        }
                                    }
                                }
                                $existingReport = ReportGeofence::where('geofence_id', $value['id'])
                                    ->where('target_id', $radarData->target_id)
                                    ->orderBy('in', 'desc')
                                    ->first();
                                if (!$existingReport || $existingReport->in->diffInHours(Carbon::parse($radarData->timestamp)) > 5) {
                                    ReportGeofence::updateOrCreate(
                                        [
                                            'target_id' => $radarData->target_id,
                                        ],
                                        [
                                            'event_id' => 9,
                                            'geofence_id' => $value['id'],
                                            'in' => Carbon::parse($radarData->timestamp)
                                        ]
                                    );
                                }
                            } else {
                                $washere = EventTracking::where('target_id', $radarData->target_id)
                                    ->where('event_id', 9)->where('geofence_id', $value['id'])->first();
                                if ($washere) {
                                    $existingReport = ReportGeofence::where('target_id', $radarData->target_id)
                                        ->where('geofence_id', $value['id'])
                                        ->whereNull('out')
                                        ->whereNotNull('in')
                                        ->first();

                                    if ($existingReport) {
                                        $existingReport->update([
                                            'out' => Carbon::parse($radarData->timestamp),
                                            'total_time' => $existingReport->in->diffInMinutes($radarData->timestamp)
                                        ]);

                                        EventTracking::create([
                                            'event_id' => 10,
                                            'target_id' => $radarData->target_id,
                                            'geofence_id' => $value['id']
                                        ]);
                                        try {
                                            Http::post($url, [
                                                'msg' => $radarData->target_id . ' Outside ' . $value['geofence_name'] . ' Geofence ~ Speed  ' . $radarData->speed, 'type' => 'notif'
                                            ]);
                                        } catch (\Exception $e) {
                                        }
                                        try {
                                            $recipient = User::first();

                                            Notification::make()
                                                ->title($radarData->target_id . ' Outside ' . $value['geofence_name'] . ' Geofence ~ Speed  ' . $radarData->speed)
                                                ->sendToDatabase($recipient);
                                        } catch (\Exception $e) {
                                        }
                                    }
                                }
                            }
                        } else {
                            // Handle other cases
                            $isInside = [];
                        }
                    }
                }
            }

            // Return a success JSON response
            return response()->json(['status' => 'success']);
        } catch (\Exception $e) {
            // Log the error
            \Log::error('Error in fetchradar: ' . $e->getMessage());

            // Return an error JSON response
            return response()->json(['status' => 'error', 'message' => $e->getMessage()], 500);
        }
    }

    public function radararpha()
    {
        if (empty(request())) {
            return response()->json([
                'error' => 'No request payload provided.',
            ], 400);
        }

        foreach (request()->all() as $item) {
            $datalogger = Datalogger::find(1);
            $coordinate1 = new Coordinate($datalogger->latitude, $datalogger->longitude);
            $coordinate2 = new Coordinate($item['latitude'], $item['longitude']);
            $distance = $coordinate1->getDistance($coordinate2, new Haversine());
            $distanceInKilometers = $distance / 1000;
            $distanceInNauticalMiles = $distanceInKilometers * 0.539957;

            $radarData = RadarData::updateOrCreate(
                ['target_id' => $item['target_id']],
                [
                    'latitude' => $item['latitude'],
                    'longitude' => $item['longitude'],
                    'altitude' => $item['altitude'],
                    'speed' => $item['speed'],
                    'course' => $item['course'],
                    'heading' => $item['heading'],
                    'range' => $item['range'],
                    'bearing' => $item['bearing'],
                    'timestamp' => $item['timestamp'],
                    'distance_from_fak' => $distanceInNauticalMiles,
                ]
            );

            $defaultValue = env('APP_ENV_CHECK', 'local');
            $url = $defaultValue == 'local'
                ? 'http://localhost:1880/sendgeofencealarmksop'
                : 'https://nr.monitormyvessel.com/sendgeofencealarmksop';
            // $geofenceDatas = Geofence::all();
            $geofenceDatas = Cache::remember('geofences', 3 * 60, function () {
                return Geofence::where('isMaster', 0)->get();
            });
            foreach ($geofenceDatas as $value) {
                if ($value->geometry) {
                    $geoParse = json_decode($value->geometry);

                    if ($geoParse && $value->type_geo === 'circle') {
                        $jarak = $this->distance(
                            request()->latitude,
                            request()->longitude,
                            $geoParse->geometry->coordinates[1],
                            $geoParse->geometry->coordinates[0],
                            'K'
                        );
                        if ($jarak <= (float) $value['radius'] / 1000) {
                            if ($value['type'] === 'in' || $value['type'] === 'both') {
                                $lastEventTimestamp = EventTracking::where('target_id', $radarData->target_id)
                                    ->where('geofence_id', $value['id'])
                                    ->whereDate('created_at', Carbon::today())
                                    ->value('created_at');

                                // If no event recorded today, create a new event
                                if (!$lastEventTimestamp || Carbon::parse($lastEventTimestamp)->diffInHours($radarData->timestamp) > 5) {
                                    EventTracking::create([
                                        'event_id' => 9,
                                        'target_id' => $radarData->target_id,
                                        'geofence_id' => $value['id']
                                    ]);
                                    $radarData->is_inside_geofence = 1;
                                    $radarData->update();

                                    try {
                                        Http::post($url, [
                                            'msg' => $radarData->target_id . ' Inside ' . $value['geofence_name'] . ' Geofence ~ Speed  ' . $radarData->speed
                                        ]);
                                    } catch (\Exception $e) {
                                        // Handle the exception here, you can log it or take appropriate action
                                        // For example:
                                        // Log::error('HTTP POST failed: ' . $e->getMessage());
                                    }
                                    try {
                                        $recipient = User::first();

                                        Notification::make()
                                            ->title($radarData->target_id . ' Inside ' . $value['geofence_name'] . ' Geofence ~ Speed  ' . $radarData->speed)
                                            ->sendToDatabase($recipient);
                                    } catch (\Exception $e) {
                                    }
                                }
                            }
                            $existingReport = ReportGeofence::where('geofence_id', $value['id'])
                                ->where('target_id', $radarData->target_id)
                                ->orderBy('in', 'desc')
                                ->first();
                            if (!$existingReport || $existingReport->in->diffInHours(Carbon::parse($radarData->timestamp)) > 5) {
                                ReportGeofence::updateOrCreate(
                                    [
                                        'target_id' => $radarData->target_id,
                                    ],
                                    [
                                        'event_id' => 9,
                                        'geofence_id' => $value['id'],
                                        'in' => Carbon::parse($radarData->timestamp)
                                    ]
                                );
                            }
                        } else {
                            $washere = EventTracking::where('target_id', $radarData->target_id)
                                ->where('event_id', 9)->where('geofence_id', $value['id'])->first();
                            if ($washere) {
                                $existingReport = ReportGeofence::where('target_id', $radarData->target_id)
                                    ->where('geofence_id', $value['id'])
                                    ->whereNull('out')
                                    ->whereNotNull('in')
                                    ->first();

                                if ($existingReport) {
                                    $existingReport->update([
                                        'out' => Carbon::parse($radarData->timestamp),
                                        'total_time' => $existingReport->in->diffInMinutes($radarData->timestamp)
                                    ]);
                                    EventTracking::create([
                                        'event_id' => 10,
                                        'target_id' => $radarData->target_id,
                                        'geofence_id' => $value['id']
                                    ]);

                                    $message = $radarData->target_id . ' Outside ' . $value['geofence_name'] . ' Geofence ~ Speed  ' . $radarData->speed;
                                    try {
                                        Http::post($url, ['msg' => $message]);
                                    } catch (\Exception $e) {
                                    }
                                    try {
                                        $recipient = User::first();

                                        Notification::make()
                                            ->title($message)
                                            ->sendToDatabase($recipient);
                                    } catch (\Exception $e) {
                                    }
                                }
                            }
                        }
                    } else if ($geoParse && ($value->type_geo === 'polygon' || $value->type_geo === 'rectangle')) {
                        // Handle polygon or rectangle case
                        $geofence = new Polygon();
                        foreach ($geoParse as $valGeo) {
                            $geofence->addPoint(new Coordinate($valGeo[0], $valGeo[1]));
                        }
                        $insidePoint = new Coordinate($radarData->latitude, $radarData->longitude);
                        if ($geofence->contains($insidePoint)) {
                            if ($value['type'] === 'in' || $value['type'] === 'both') {
                                $lastEventTimestamp = EventTracking::where('target_id', $radarData->target_id)
                                    ->where('geofence_id', $value['id'])
                                    ->whereDate('created_at', Carbon::today())
                                    ->value('created_at');

                                // If no event recorded today, create a new event
                                if (!$lastEventTimestamp || Carbon::parse($lastEventTimestamp)->diffInHours($radarData->timestamp) > 5) {
                                    EventTracking::create([
                                        'event_id' => 9,
                                        'target_id' => $radarData->target_id,
                                        'geofence_id' => $value['id']
                                    ]);
                                    $radarData->is_inside_geofence = 1;
                                    $radarData->update();
                                    try {
                                        Http::post($url, [
                                            'msg' => $radarData->target_id . ' Inside ' . $value['geofence_name'] . ' Geofence ~ Speed  ' . $radarData->speed
                                        ]);
                                    } catch (\Exception $e) {
                                    }
                                    try {
                                        $recipient = User::first();

                                        Notification::make()
                                            ->title($radarData->target_id . ' Inside ' . $value['geofence_name'] . ' Geofence ~ Speed  ' . $radarData->speed)
                                            ->sendToDatabase($recipient);
                                    } catch (\Exception $e) {
                                    }
                                }
                            }
                            $existingReport = ReportGeofence::where('geofence_id', $value['id'])
                                ->where('target_id', $radarData->target_id)
                                ->orderBy('in', 'desc')
                                ->first();
                            if (!$existingReport || $existingReport->in->diffInHours(Carbon::parse($radarData->timestamp)) > 5) {
                                ReportGeofence::updateOrCreate(
                                    [
                                        'target_id' => $radarData->target_id,
                                    ],
                                    [
                                        'event_id' => 9,
                                        'geofence_id' => $value['id'],
                                        'in' => Carbon::parse($radarData->timestamp)
                                    ]
                                );
                            }
                        } else {
                            $washere = EventTracking::where('target_id', $radarData->target_id)
                                ->where('event_id', 9)->where('geofence_id', $value['id'])->first();
                            if ($washere) {
                                $existingReport = ReportGeofence::where('target_id', $radarData->target_id)
                                    ->where('geofence_id', $value['id'])
                                    ->whereNull('out')
                                    ->whereNotNull('in')
                                    ->first();

                                if ($existingReport) {
                                    $existingReport->update([
                                        'out' => Carbon::parse($radarData->timestamp),
                                        'total_time' => $existingReport->in->diffInMinutes($radarData->timestamp)
                                    ]);

                                    EventTracking::create([
                                        'event_id' => 10,
                                        'target_id' => $radarData->target_id,
                                        'geofence_id' => $value['id']
                                    ]);
                                    try {
                                        Http::post($url, [
                                            'msg' => $radarData->target_id . ' Outside ' . $value['geofence_name'] . ' Geofence ~ Speed  ' . $radarData->speed
                                        ]);
                                    } catch (\Exception $e) {
                                    }
                                    try {
                                        $recipient = User::first();

                                        Notification::make()
                                            ->title($radarData->target_id . ' Outside ' . $value['geofence_name'] . ' Geofence ~ Speed  ' . $radarData->speed)
                                            ->sendToDatabase($recipient);
                                    } catch (\Exception $e) {
                                    }
                                }
                            }
                        }
                    } else {
                        // Handle other cases
                        $isInside = [];
                    }
                }
            }
        }

        return response()->json([
            'radarData' => $radarData ?? null,
        ], 201);
    }

    public function radarimage()
    {
        //http://bst.cakrawala.id/radarfolder/radar.png

        return response()->json([
            'success' => true,
            'message' => 'http://bst.cakrawala.id/radarfolder/radar.png',
        ], 201);
    }
}
