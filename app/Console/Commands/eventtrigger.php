<?php

namespace App\Console\Commands;

use App\Models\AisDataPosition;
use App\Models\Asset;
use App\Models\Datalogger;
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

        $datalogger = Datalogger::first();

        //$datalogger has lat & long

        $allAssets = Asset::with('aisDataVessel')->get();

        // ON/OFF AIS Receiver Coverage
        // the coverage is from $datalogger->coverage
        // if asset position (AisDataPosition) outside coverage then create EventTracking with event_id 5 else 4

        // AIS ON/OFF
        foreach ($allAssets as $asset) {
            if ($asset->aisDataVessel) {
                $vesselId = $asset->aisDataVessel->id;
                $aisStatus = AisDataPosition::isAisOn($vesselId);
                $latestAisData = AisDataPosition::where('vessel_id', $vesselId)
                    ->orderBy('created_at', 'DESC')
                    ->first();

                // Check AIS Receiver Coverage
                $latTerakhirKapal = $latestAisData->latitude;
                $lonTerakhirKapal = $latestAisData->longitude;
                $coverage = $datalogger->coverage;

                if ($this->isPositionOutsideCoverage($latTerakhirKapal, $lonTerakhirKapal, $datalogger, $coverage)) {
                    EventTracking::create([
                        'asset_id' => $asset->id,
                        'event_id' => 5,
                        'ais_data_position_id' => $latestAisData->id,
                    ]);
                    echo "Asset {$asset->asset_name}: AIS Receiver Coverage OFF\n";
                } else {
                    // AIS Receiver Coverage is ON, continue with AIS status check
                    echo "Asset {$asset->asset_name}: AIS Receiver Coverage ON\n";

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
                }
            } else {
                echo "Asset {$asset->asset_name}: AIS data not available\n";
            }
        }
    }

    // Function to check if the position is outside coverage
    function isPositionOutsideCoverage($latKapal, $lonKapal, $datalogger, $coverage)
    {
        // Implement your logic to check if the position is outside coverage
        // Compare $position with $coverage and return true if outside coverage, false otherwise
        // Example: return $position < $coverage['min_lat'] || $position > $coverage['max_lat'] || $position < $coverage['min_long'] || $position > $coverage['max_long'];
    }
}
