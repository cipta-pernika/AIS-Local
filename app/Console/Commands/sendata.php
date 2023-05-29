<?php

namespace App\Console\Commands;

use App\Models\AisDataPosition;
use App\Models\Datalogger;
use App\Models\DataTransferLog;
use App\Models\Sensor;
use Carbon\Carbon;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Http;
use Location\Coordinate;
use Location\Distance\Haversine;

class sendata extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:sendata';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Send All Data to Server';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $datalogger = Datalogger::find(1);
        $sensor = Sensor::find(1);

        $logtransfer = DataTransferLog::latest()->first();

        if ($logtransfer) {
        } else {
            //filter by jumlah data
            if ($sensor->jumlah_data === 0) {
                $aisData = AisDataPosition::with('vessel', 'sensorData.sensor.datalogger')
                    ->get();
            } else {
                $aisData = AisDataPosition::with('vessel', 'sensorData.sensor.datalogger')
                    ->limit($sensor->jumlah_data)
                    ->get();
            }

            //filter by jarak
            if ($sensor->jarak === 0) {
                $newArray = $aisData;
            } else {
                $newArray = [];
                foreach ($aisData as $key => $item) {
                    $coordinate1 = new Coordinate($datalogger->latitude, $datalogger->longitude);
                    $coordinate2 = new Coordinate($item->latitude, $item->longitude);
                    $distance = $coordinate1->getDistance($coordinate2, new Haversine());
                    $distanceInKilometers = $distance / 1000;
                    $distanceInNauticalMiles = $distanceInKilometers * 0.539957;
                    if ($distanceInNauticalMiles <= $sensor->jarak) {
                        $newArray[] = $item;
                    }
                }
            }
            $response = Http::post('http://localhost:1880/api/nampungdata', [
                'aisdata' => $newArray
            ]);
            $createlog = new DataTransferLog();
            $createlog->timestamp = Carbon::now();
            $createlog->response_code = $response->status();
            if ($response->successful()) {
                $createlog->response_time = $response->header('X-Response-Time');
            } else {
                $createlog->response_time = null;
                $createlog->additional_info = $response->body();
            }
            $createlog->save();
            dd($response);
        }
    }
}
