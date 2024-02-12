<?php

namespace App\Console\Commands;

use App\Models\Location;
use App\Models\Terminal;
use Illuminate\Console\Command;

class terminalintolocation extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:terminalintolocation';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Convert terminal into location';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $terminals = Terminal::all();

        foreach($terminals as $terminal){
            $location = new Location();
            $location->name = $terminal->name;
            $location->location_type_id = 9;
            $location->latitude = $terminal->latitude;
            $location->longitude = $terminal->longitude;
            $location->save();
        }
    }
}
