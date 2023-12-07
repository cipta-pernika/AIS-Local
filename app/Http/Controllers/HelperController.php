<?php

namespace App\Http\Controllers;

use App\Models\AdsbData;
use App\Models\AdsbDataAircraft;
use App\Models\AdsbDataFlight;
use App\Models\AdsbDataPosition;
use App\Models\AisDataPosition;
use App\Models\AisDataVessel;
use App\Models\Datalogger;
use App\Models\DataTransferLog;
use App\Models\RadarData;
use App\Models\Sensor;
use App\Models\SensorData;
use Barryvdh\DomPDF\Facade\Pdf;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Location\Bearing\BearingSpherical;
use Location\Coordinate;
use Location\Distance\Haversine;
use Location\Distance\Vincenty;

class HelperController extends Controller
{
    public function search()
    {
        $search = AisDataVessel::where('mmsi', request('query'))->with('positions')->first();

        return response()->json([
            'success' => true,
            'message' => $search,
        ], 201);
    }
    public function datatransferlogspost()
    {
        $createlog = new DataTransferLog();
        $createlog->timestamp = Carbon::now();
        $createlog->response_code = 200;
        $createlog->additional_info = request('msg');
        $createlog->save();

        return response()->json([
            'success' => true,
            'message' => $createlog,
        ], 201);
    }

    public function datatransferlogs()
    {
        $datatransferlog = DataTransferLog::orderBy('created_at', 'DESC')->whereBetween('created_at', [now()->subHours(2), now()])->limit(100)->get();

        return response()->json([
            'success' => true,
            'message' => $datatransferlog,
        ], 201);
    }

    public function dailyreport()
    {
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
            ->whereBetween('created_at', [now()->subMinutes(5), now()])
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
        $zoom = 25;

        $xml_data = '<PTZData version="2.0" xmlns="http://www.isapi.org/ver20/XMLSchema">
        <AbsoluteHigh>
        <elevation>' . $tilt . ' </elevation>
        <azimuth>' . ($bearing) . ' </azimuth>
        <absoluteZoom>' . $zoom . ' </absoluteZoom>
        </AbsoluteHigh>
        </PTZData>';

        $url = 'http://admin:Amtek12345@192.168.5.222/PTZCtrl/channels/1/absolute';
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

        if (request()->mmsi) {
            $vessel = AisDataVessel::updateOrCreate(['mmsi' => request()->mmsi]);

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
        }

        $aisData = AisDataPosition::with('vessel', 'sensorData.sensor.datalogger')
            ->orderBy('created_at', 'DESC')
            ->groupBy('vessel_id')
            ->where('id', $vesselPosition->id)
            ->first();

        return response()->json([
            'aisData' => $aisData,
            // 'sensor' => $sensor,
            // 'sensorData' => $sensorData,
            // 'vessel' => $vessel ?? null,
            // 'vesselPosition' => $vesselPosition ?? null,
        ], 201);
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
        $aisData = AisDataPosition::with('vessel', 'sensorData.sensor.datalogger')
            ->orderBy('created_at', 'DESC')
            ->groupBy('vessel_id')
            ->whereBetween('created_at', [now()->subMinutes(5), now()])
            // ->whereBetween('created_at', [now()->subHours(124), now()])
            ->get();

        return response()->json([
            'success' => true,
            'message' => $aisData,
        ], 201);
    }

    public function aisdatauniquefe()
    {
        $aisData = AisDataPosition::with('vessel', 'sensorData.sensor.datalogger')
            ->orderBy('created_at', 'DESC')
            ->groupBy('vessel_id')
            ->whereBetween('created_at', [now()->subMinutes(5), now()])
            ->get();

        return response()->json([
            'success' => true,
            'message' => $aisData,
        ], 201);
    }

    public function aisdataupdate()
    {
        $aisData = AisDataPosition::with('vessel', 'sensorData.sensor.datalogger')
            ->orderBy('created_at', 'DESC')
            ->groupBy('vessel_id')
            ->whereBetween('created_at', [now()->subMinutes(5), now()])
            // ->whereBetween('created_at', [now()->subMinutes(322), now()])
            // ->limit(10)
            ->get();

        return response()->json([
            'success' => true,
            'message' => $aisData,
        ], 201);
    }

    public function aisdatalist()
    {
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
            ->values() // Reset the keys and convert back to a simple array.
            ->toArray();

        // Now $aisData is an array of arrays, each representing the properties of a vessel.

        return response()->json([
            'success' => true,
            'message' => $aisData,
        ], 201);
    }

    public function adsbdatalist()
    {
        $aisData = AdsbDataPosition::with('aircraft', 'sensorData.sensor.datalogger')
            ->orderBy('created_at', 'DESC')
            ->limit(200)
            ->get();

        return response()->json([
            'success' => true,
            'message' => $aisData,
        ], 201);
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
        $aisData = AisDataPosition::with('vessel')
            ->groupBy('vessel_id')
            ->limit(10)
            ->orderBy('created_at', 'DESC')
            ->whereBetween('created_at', [now()->subMinutes(5), now()])
            ->get();

        $adsb = AdsbDataPosition::with('aircraft')
            ->groupBy('aircraft_id')
            ->limit(10)
            ->orderBy('created_at', 'DESC')
            ->whereBetween('created_at', [now()->subMinutes(5), now()])
            ->get();

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
            // ->whereBetween('created_at', [now()->subHours(12), now()])
        // ->groupBy('aircraft_id')
        // ->whereBetween('created_at', [now()->subHours(12), now()])
        ->whereBetween('created_at', [now()->subMinutes(5), now()])
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
            // ->whereBetween('created_at', [now()->subHours(12), now()])
            ->whereBetween('created_at', [now()->subMinutes(5), now()])
            // ->orderBy('created_at', 'DESC')
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
            ->whereBetween('created_at', [now()->subMinutes(2), now()])
        // ->orderBy('created_at', 'DESC')
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
            ->whereBetween('created_at', [now()->subMinutes(5), now()])
            ->orderBy('created_at', 'DESC')
            // ->whereBetween('created_at', [now()->subHours(120), now()])
            ->limit(30)
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
            // ->whereBetween('created_at', [now()->subHours(1), now()])
            ->whereBetween('created_at', [now()->subMinutes(5), now()])
            ->limit(30)
            ->get();

        return response()->json([
            'success' => true,
            'message' => $aisData,
        ], 201);
    }

    public function radardataupdate()
    {
        $aisData = RadarData::with('sensorData.sensor.datalogger')
            ->groupBy('target_id')
            ->whereBetween('created_at', [now()->subMinutes(2), now()])
            ->limit(10)
            ->get();

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
            ->whereBetween('created_at', [now()->subMinutes(5), now()])
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
        $xml_data = '<PTZData version="2.0" xmlns="http://www.isapi.org/ver20/XMLSchema">' .
            '<zoom>-10</zoom>' .
            '<Momentary>' .
            '<duration> 1000 </duration>' .
            '</Momentary>' .
            '</PTZData>';

        $url = 'http://admin:Amtek12345@192.168.5.222/PTZCtrl/channels/1/momentary';
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

        $url = 'http://admin:Amtek12345@192.168.5.222/PTZCtrl/channels/1/continuous';
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

        $url = 'http://admin:Amtek12345@192.168.5.222/PTZCtrl/channels/1/momentary';
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

        $url = 'http://admin:Amtek12345@192.168.5.222/PTZCtrl/channels/1/momentary';
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

        $url = 'http://admin:Amtek12345@192.168.5.222/PTZCtrl/channels/1/continuous';
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

        $url = 'http://admin:Amtek12345@192.168.5.222/PTZCtrl/channels/1/momentary';
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

        $url = 'http://admin:Amtek12345@192.168.5.222/PTZCtrl/channels/1/continuous';
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

        $url = 'http://admin:Amtek12345@192.168.5.222/PTZCtrl/channels/1/momentary';
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

        $url = 'http://admin:Amtek12345@192.168.5.222/PTZCtrl/channels/1/continuous';
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

        $url = 'http://admin:Amtek12345@192.168.5.222/PTZCtrl/channels/1/continuous';
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

        $url = 'http://admin:Amtek12345@192.168.5.222/PTZCtrl/channels/1/continuous';
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

        $url = 'http://admin:Amtek12345@192.168.5.222/PTZCtrl/channels/1/continuous';
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

        $url = 'http://admin:Amtek12345@192.168.5.222/PTZCtrl/channels/1/momentary';
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

        $url = 'http://admin:Amtek12345@192.168.5.222/PTZCtrl/channels/1/continuous';
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

        $url = 'http://admin:Amtek12345@192.168.5.222/PTZCtrl/channels/1/continuous';
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

        $url = 'http://admin:Amtek12345@192.168.5.222/PTZCtrl/channels/1/momentary';
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

        $url = 'http://admin:Amtek12345@192.168.5.222/ISAPI/PTZCtrl/channels/1/autoPan';
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

        $url = 'http://admin:Amtek12345@192.168.5.222/ISAPI/PTZCtrl/channels/1/autoPan';
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

        $url = 'http://admin:Amtek12345@192.168.5.222/ISAPI/System/Video/inputs/channels/1/focus';
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

        $url = 'http://admin:Amtek12345@192.168.5.222/ISAPI/System/Video/inputs/channels/1/focus';
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

        $url = 'http://admin:Amtek12345@192.168.5.222/ISAPI/System/Video/inputs/channels/1/focus';
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

        $url = 'http://admin:Amtek12345@192.168.5.222/ISAPI/PTZCtrl/channels/1/continuous';
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
        $url = 'http://admin:Amtek12345@192.168.5.222/ISAPI/PTZCtrl/channels/1/homePosition/goto';

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
        $url = 'http://admin:Amtek12345@192.168.5.222/ISAPI/PTZCtrl/channels/1/homePosition';
        $ch = curl_init($url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'PUT');
        curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: text/xml'));

        curl_setopt($ch, CURLOPT_POSTFIELDS, ''); // Empty body as specified in the cURL command

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

    public function camirismin()
    {
        $xml_data = '<IrisData>' .
            '<iris>-60</iris>' .
            '</IrisData>';

        $url = 'http://admin:Amtek12345@192.168.5.222/ISAPI/System/Video/inputs/channels/1/iris';
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

        $url = 'http://admin:Amtek12345@192.168.5.222/ISAPI/System/Video/inputs/channels/1/iris';
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

        $url = 'http://admin:Amtek12345@192.168.5.222/ISAPI/System/Video/inputs/channels/1/iris';
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

        $url = 'http://admin:Amtek12345@192.168.5.222/ISAPI/PTZCtrl/channels/1/auxcontrols/1';
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

        $url = 'http://admin:Amtek12345@192.168.5.222/ISAPI/PTZCtrl/channels/1/auxcontrols/1';
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
        $url = 'http://admin:Amtek12345@192.168.5.222/ISAPI/PTZCtrl/channels/1/presets/95/goto';
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
        }

        return response()->json([
            'radarData' => $radarData ?? null,
        ], 201);
    }

    public function radarimage()
    {
        return response()->json([
            'success' => true,
            'message' => 'http://172.16.172.8/radarfolder/radar.png',
        ], 201);
    }
}
