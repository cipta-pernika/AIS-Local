<?php

namespace App\Console\Commands;

use App\Models\AisDataVessel;
use Carbon\Carbon;
use Illuminate\Console\Command;

class outofrange extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:outofrange';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Check Out of Range AIS';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        //tambahkan arah kapal menjauh dari FAK
        //navigation status bisa di pertimbangakan
        $distanceThreshold = 20; //NM
        $maxMinutesSinceLastPosition = 3; //minutes

        $currentTime = Carbon::now();
        $lastValidPositionTime = $currentTime->subMinutes($maxMinutesSinceLastPosition);

        $vesselsInRange = AisDataVessel::where('out_of_range', '0')
            ->whereHas('positions', function ($query) use ($distanceThreshold, $lastValidPositionTime) {
                $query->where('distance', '>', $distanceThreshold)
                    ->where('created_at', '>=', $lastValidPositionTime);
            })
            ->get();

        foreach ($vesselsInRange as $vessel) {
            $vessel->out_of_range = '1';
            $vessel->update();
        }
    }
}
