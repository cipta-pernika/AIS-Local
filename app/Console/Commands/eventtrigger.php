<?php

namespace App\Console\Commands;

use App\Models\AisDataPosition;
use App\Models\Asset;
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

        $allAssets = Asset::with('aisDataVessel')->get();

        //AIS ON/OFF
        foreach ($allAssets as $asset) {
            if ($asset->aisDataVessel) {
                $vesselId = $asset->aisDataVessel->id;
                $aisStatus = AisDataPosition::isAisOn($vesselId);

                echo "Asset {$asset->asset_name}: AIS is " . ($aisStatus ? 'ON' : 'OFF') . "\n";
            } else {
                echo "Asset {$asset->asset_name}: AIS data not available\n";
            }
        }
    }
}
