<?php

namespace App\Http\Controllers;

use App\Models\AdsbData;
use App\Models\AdsbDataAircraft;
use App\Models\AdsbDataFlight;
use App\Models\AdsbDataPosition;
use App\Models\AisDataPosition;
use App\Models\AisDataVessel;
use App\Models\RadarData;
use App\Models\Sensor;
use App\Models\SensorData;
use App\Models\Vessel;
use Carbon\Carbon;

class HelperController extends Controller
{
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
                'mmsi' => request()->senderMmsi
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

        return response()->json([
            'sensor' => $sensor,
            'sensorData' => $sensorData,
            'vessel' => $vessel ?? null,
            'vesselPosition' => $vesselPosition ?? null
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
            ->groupBy('vessel_id')
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
            dd($item);

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
                    'mmsi' => request()->senderMmsi
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
            'vesselPosition' => $vesselPosition ?? null
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
                'timestamp' => Carbon::parse(request('generated_date') . ' ' .  request('generated_time')),
            ]);
            $sensorData->save();

            if (request()->hex_ident) {
                $vessel = AdsbDataAircraft::updateOrCreate(['hex_ident' => request()->hex_ident],
                 ['callsign'  => request()->callsign]);

                $flight = AdsbDataFlight::updateOrCreate(['flight_number' => request()->flight_id]);

                $latitude = request()->lat;
                $longitude = request()->lon;
                if ($this->isValidLatitude($latitude) && $this->isValidLongitude($longitude)) {
                    $vesselPosition = new AdsbDataPosition([
                        'sensor_data_id' => $sensorData->id,
                        'aircraft_id' => $vessel->id,
                        'flight_id' => $flight->id,
                        'latitude' => $latitude,
                        'longitude' => $longitude,
                        'altitude' => request()->altitude,
                        'ground_speed' => request()->ground_speed,
                        'vertical_rate' => request()->vertical_rate,
                        'track' => request()->track,
                        'timestamp' => Carbon::parse(request('generated_date') . ' ' .  request('generated_time')),
                        'transmission_type' => request()->transmission_type,
                    ]);
                    $vesselPosition->save();
                }
            }

        return response()->json([
            'sensor' => $sensor,
            'sensorData' => $sensorData,
            'vessel' => $vessel ?? null,
            'vesselPosition' => $vesselPosition ?? null
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

        $url = 'http://admin:Amtek12345@192.168.55.222/PTZCtrl/channels/1/momentary';
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

        $url = 'http://admin:Amtek12345@192.168.55.222/PTZCtrl/channels/1/continuous';
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

        $url = 'http://admin:Amtek12345@192.168.55.222/PTZCtrl/channels/1/momentary';
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

        $url = 'http://admin:Amtek12345@192.168.55.222/PTZCtrl/channels/1/momentary';
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

        $url = 'http://admin:Amtek12345@192.168.55.222/PTZCtrl/channels/1/continuous';
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

        $url = 'http://admin:Amtek12345@192.168.55.222/PTZCtrl/channels/1/momentary';
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

        $url = 'http://admin:Amtek12345@192.168.55.222/PTZCtrl/channels/1/continuous';
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

        $url = 'http://admin:Amtek12345@192.168.55.222/PTZCtrl/channels/1/momentary';
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

        $url = 'http://admin:Amtek12345@192.168.55.222/PTZCtrl/channels/1/continuous';
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

        $url = 'http://admin:Amtek12345@192.168.55.222/PTZCtrl/channels/1/continuous';
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

        $url = 'http://admin:Amtek12345@192.168.55.222/PTZCtrl/channels/1/continuous';
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

        $url = 'http://admin:Amtek12345@192.168.55.222/PTZCtrl/channels/1/continuous';
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

        $url = 'http://admin:Amtek12345@192.168.55.222/PTZCtrl/channels/1/momentary';
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

        $url = 'http://admin:Amtek12345@192.168.55.222/PTZCtrl/channels/1/continuous';
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

        $url = 'http://admin:Amtek12345@192.168.55.222/PTZCtrl/channels/1/continuous';
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

        $url = 'http://admin:Amtek12345@192.168.55.222/PTZCtrl/channels/1/momentary';
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

        $url = 'http://admin:Amtek12345@192.168.55.222/ISAPI/PTZCtrl/channels/1/autoPan';
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

        $url = 'http://admin:Amtek12345@192.168.55.222/ISAPI/PTZCtrl/channels/1/autoPan';
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

        $url = 'http://admin:Amtek12345@192.168.55.222/ISAPI/System/Video/inputs/channels/1/focus';
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

        $url = 'http://admin:Amtek12345@192.168.55.222/ISAPI/System/Video/inputs/channels/1/focus';
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

        $url = 'http://admin:Amtek12345@192.168.55.222/ISAPI/System/Video/inputs/channels/1/focus';
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

        $url = 'http://admin:Amtek12345@192.168.55.222/ISAPI/PTZCtrl/channels/1/continuous';
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

    public function camirismin()
    {
        $xml_data = '<IrisData>' .
            '<iris>-60</iris>' .
            '</IrisData>';

        $url = 'http://admin:Amtek12345@192.168.55.222/ISAPI/System/Video/inputs/channels/1/iris';
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

        $url = 'http://admin:Amtek12345@192.168.55.222/ISAPI/System/Video/inputs/channels/1/iris';
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

        $url = 'http://admin:Amtek12345@192.168.55.222/ISAPI/System/Video/inputs/channels/1/iris';
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

        $url = 'http://admin:Amtek12345@192.168.55.222/ISAPI/PTZCtrl/channels/1/auxcontrols/1';
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

        $url = 'http://admin:Amtek12345@192.168.55.222/ISAPI/PTZCtrl/channels/1/auxcontrols/1';
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
        $url = 'http://admin:Amtek12345@192.168.55.222/ISAPI/PTZCtrl/channels/1/presets/95/goto';
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
        if (empty(request()->source)) {
            return response()->json([
                'error' => 'No request payload provided.',
            ], 400);
        }

        $sensor = Sensor::find(2);

        $sensorData = new SensorData([
            'sensor_id' => $sensor->id,
            'payload' => request()->source,
            'timestamp' => Carbon::parse(request()->isoDate),
        ]);
        $sensorData->save();

        $radarData = new RadarData([
            'sensor_data_id' => $sensorData->id,
            'target_id' => request()->target_id,
            'latitude' => request()->latitude,
            'longitude' => request()->longitude,
            'altitude' => request()->altitude,
            'speed' => request()->speed,
            'heading' => request()->heading,
            'course' => request()->course,
            'range' => request()->range,
            'bearing' => request()->bearing,
            'timestamp' => Carbon::parse(request()->isoDate),
        ]);
        $radarData->save();

        return response()->json([
            'sensor' => $sensor,
            'sensorData' => $sensorData,
            'radarData' => $radarData ?? null
        ], 201);
    }
}
