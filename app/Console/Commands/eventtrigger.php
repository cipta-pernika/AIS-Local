<?php

namespace App\Console\Commands;

use App\Models\AisDataPosition;
use App\Models\Asset;
use App\Models\EventTracking;
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

        // AIS ON/OFF
        foreach ($allAssets as $asset) {
            if ($asset->aisDataVessel) {
                $vesselId = $asset->aisDataVessel->id;
                $aisStatus = AisDataPosition::isAisOn($vesselId);
                $latestAisData = AisDataPosition::where('vessel_id', $vesselId)
                    ->orderBy('created_at', 'DESC')
                    ->first();

                echo "Asset {$asset->asset_name}: AIS is " . ($aisStatus ? 'ON' : 'OFF') . "\n";

                // Check the AIS status directly instead of comparing it with a string
                if ($aisStatus) {
                    // AIS is ON, insert record into event_trackings
                    EventTracking::create([
                        'asset_id' => $asset->id, // Replace with the actual asset_id
                        'event_id' => 2,
                        'ais_data_position_id' => $latestAisData->id, // Use $vesselId instead of $aisStatus->id
                    ]);
                } else {
                    EventTracking::create([
                        'asset_id' => $asset->id, // Replace with the actual asset_id
                        'event_id' => 3,
                        'ais_data_position_id' => $latestAisData->id, // Set to null or handle accordingly
                    ]);
                }
            } else {
                echo "Asset {$asset->asset_name}: AIS data not available\n";
            }
        }
    }
}
