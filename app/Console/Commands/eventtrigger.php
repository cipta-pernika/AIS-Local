<?php

namespace App\Console\Commands;

use App\Models\AisDataPosition;
use App\Models\Asset;
use App\Models\Datalogger;
use App\Models\EventTracking;
use Location\Coordinate;
use Location\Distance\Vincenty;
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

        $allAssets = Asset::with('aisDataVessel')->get();

        foreach ($allAssets as $asset) {
            if ($asset->aisDataVessel) {
                $vesselId = $asset->aisDataVessel->id;
                $aisStatus = AisDataPosition::isAisOn($vesselId);
                $latestAisData = AisDataPosition::where('vessel_id', $vesselId)
                    ->orderBy('created_at', 'DESC')
                    ->first();

                // Check AIS Receiver Coverage
                if ($latestAisData) {

                    $latTerakhirKapal = $latestAisData->latitude;
                    $lonTerakhirKapal = $latestAisData->longitude;

                    // ON/OFF AIS Receiver Coverage
                    if ($this->isPositionOutsideCoverage($latTerakhirKapal, $lonTerakhirKapal, $datalogger)) {
                        EventTracking::create([
                            'asset_id' => $asset->id,
                            'event_id' => 5,
                            'ais_data_position_id' => $latestAisData->id,
                            'mmsi' => $asset->mmsi,
                            'ship_name' => $asset->asset_name
                        ]);
                        echo "Asset {$asset->asset_name}: AIS Receiver Coverage OFF\n";
                    } else {
                        // AIS Receiver Coverage is ON, continue with AIS status check
                        echo "Asset {$asset->asset_name}: AIS Receiver Coverage ON\n";
                        EventTracking::create([
                            'asset_id' => $asset->id,
                            'event_id' => 4,
                            'ais_data_position_id' => $latestAisData->id,
                            'mmsi' => $asset->mmsi,
                            'ship_name' => $asset->asset_name
                        ]);

                        // AIS ON/OFF
                        // Check the AIS status directly instead of comparing it with a string
                        if ($aisStatus) {
                            // AIS is ON, insert record into event_trackings
                            EventTracking::create([
                                'asset_id' => $asset->id, // Replace with the actual asset_id
                                'event_id' => 2,
                                'ais_data_position_id' => $latestAisData->id, // Use $vesselId instead of $aisStatus->id
                                'mmsi' => $asset->mmsi,
                                'ship_name' => $asset->asset_name
                            ]);
                        } else {
                            EventTracking::create([
                                'asset_id' => $asset->id, // Replace with the actual asset_id
                                'event_id' => 3,
                                'ais_data_position_id' => $latestAisData->id, // Set to null or handle accordingly
                                'mmsi' => $asset->mmsi,
                                'ship_name' => $asset->asset_name
                            ]);
                        }
                    }
                }
            } else {
                echo "Asset {$asset->asset_name}: AIS data not available\n";
            }
        }
    }

    // Function to check if the position is outside coverage
    function isPositionOutsideCoverage($latKapal, $lonKapal, $datalogger)
    {
        $coordinate1 = new Coordinate($datalogger->latitude, $datalogger->longitude);
        $coordinate2 = new Coordinate($latKapal, $lonKapal);
        $distance = number_format($coordinate1->getDistance($coordinate2, new Vincenty()), 0, 0, 0) * 1;

        $coverageInMeters = $datalogger->coverage * 1852;

        return $distance > $coverageInMeters;
    }
}
