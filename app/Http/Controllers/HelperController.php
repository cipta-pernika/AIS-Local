<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class HelperController extends Controller
{
    public function camzoomminus()
    {
        //http://admin:Amtek2024@192.168.164.100:8080/Streaming/Channels/1/picture
        $xml_data = '<PTZData version="2.0" xmlns="http://www.isapi.org/ver20/XMLSchema">' .
            '<zoom>-10</zoom>' .
            '<Momentary>' .
            '<duration> 1000 </duration>' .
            '</Momentary>' .
            '</PTZData>';

        $url = env('CAMERA_URL') . '/PTZCtrl/channels/1/momentary';
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

        $url = env('CAMERA_URL') . '/PTZCtrl/channels/1/continuous';
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

        $url = env('CAMERA_URL') . '/PTZCtrl/channels/1/momentary';
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

        $url = env('CAMERA_URL') . '/PTZCtrl/channels/1/momentary';
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

        $url = env('CAMERA_URL') . '/PTZCtrl/channels/1/continuous';
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

        $url = env('CAMERA_URL') . '/PTZCtrl/channels/1/momentary';
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

        $url = env('CAMERA_URL') . '/PTZCtrl/channels/1/continuous';
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

        $url = env('CAMERA_URL') . '/PTZCtrl/channels/1/momentary';
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

        $url = env('CAMERA_URL') . '/PTZCtrl/channels/1/continuous';
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

        $url = env('CAMERA_URL') . '/PTZCtrl/channels/1/continuous';
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

        $url = env('CAMERA_URL') . '/PTZCtrl/channels/1/continuous';
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

        $url = env('CAMERA_URL') . '/PTZCtrl/channels/1/continuous';
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

        $url = env('CAMERA_URL') . '/PTZCtrl/channels/1/momentary';
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

        $url = env('CAMERA_URL') . '/PTZCtrl/channels/1/continuous';
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

        $url = env('CAMERA_URL') . '/PTZCtrl/channels/1/continuous';
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

        $url = env('CAMERA_URL') . '/PTZCtrl/channels/1/momentary';
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

        $url = env('CAMERA_URL') . '/ISAPI/PTZCtrl/channels/1/autoPan';
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

        $url = env('CAMERA_URL') . '/ISAPI/PTZCtrl/channels/1/autoPan';
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

        $url = env('CAMERA_URL') . '/ISAPI/System/Video/inputs/channels/1/focus';
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

        $url = env('CAMERA_URL') . '/ISAPI/System/Video/inputs/channels/1/focus';
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

        $url = env('CAMERA_URL') . '/ISAPI/System/Video/inputs/channels/1/focus';
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

        $url = env('CAMERA_URL') . '/ISAPI/PTZCtrl/channels/1/continuous';
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
        $url = env('CAMERA_URL') . '/ISAPI/PTZCtrl/channels/1/homePosition/goto';

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
        $url = env('CAMERA_URL') . '/ISAPI/PTZCtrl/channels/1/homePosition';
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

        $url = env('CAMERA_URL') . '/ISAPI/System/Video/inputs/channels/1/iris';
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

        $url = env('CAMERA_URL') . '/ISAPI/System/Video/inputs/channels/1/iris';
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

        $url = env('CAMERA_URL') . '/ISAPI/System/Video/inputs/channels/1/iris';
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

        $url = env('CAMERA_URL') . '/ISAPI/PTZCtrl/channels/1/auxcontrols/1';
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

        $url = env('CAMERA_URL') . '/ISAPI/PTZCtrl/channels/1/auxcontrols/1';
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
        $url = env('CAMERA_URL') . '/ISAPI/PTZCtrl/channels/1/presets/95/goto';
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
}
