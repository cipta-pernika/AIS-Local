<?php

namespace App\Console\Commands;

use App\Models\Geofence;
use App\Models\Location;
use App\Models\Terminal;
use Illuminate\Console\Command;

class terminalintogeofence extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:terminalintogeofence';

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
        $terminals = Terminal::limit(1000)->get();

        foreach ($terminals as $terminal) {
            $loc = Location::where('name', $terminal->name)->first();

            if ($loc) {
                $location = new Geofence();
                $location->terminal_id = $terminal->id;
                $location->location_id = $loc->id;
                $location->pelabuhan_id = $terminal->pelabuhan_id;
                $location->geofence_name = $terminal->name;
                $location->geofence_type_id = 1;
                $location->type_geo = 'circle';
                $location->radius = 500;
                $location->geometry = '{"type":"Feature","properties":[],"geometry":{"type":"Point","coordinates":[' . $terminal->longitude . ',' . $terminal->latitude . ']}}';
                $location->save();
            }
        }
    }
}
