<?php

namespace App\Console\Commands;

use App\Models\AisDataPosition;
use App\Models\DataTransferLog;
use App\Models\Sensor;
use Illuminate\Console\Command;

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
        $sensor = Sensor::find(1);

        $logtransfer = DataTransferLog::latest()->first();

        if ($logtransfer) {
        } else {
            $aisData = AisDataPosition::with('vessel', 'sensorData.sensor.datalogger')
                ->limit($sensor->jumlah_data)
                ->get();

            foreach ($aisData as $key => $item) {
                dd($item);
            }
            dd($aisData);
        }

        dd($logtransfer);
    }
}
