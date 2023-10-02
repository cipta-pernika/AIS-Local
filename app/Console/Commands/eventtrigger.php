<?php

namespace App\Console\Commands;

use App\Models\AisDataPosition;
use Illuminate\Console\Command;

class eventtrigger extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'eventtrigger';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        // $aisdata = AisDataPosition::with('vessel')
        //     ->groupBy('vessel_id')
        //     ->limit(10)
        //     ->orderBy('created_at', 'DESC')
        //     ->get();


        //AIS ON/OFF
        $vesselId = 1; // Replace with the actual vessel_id you want to check

        if (AisDataPosition::isAisOn($vesselId)) {
            echo "AIS is ON for Vessel $vesselId";
        } else {
            echo "AIS is OFF for Vessel $vesselId";
        }

        dd($vesselId);
    }
}
