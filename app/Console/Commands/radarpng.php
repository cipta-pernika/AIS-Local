<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class radarpng extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:radarpng';

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
        //
        $contents = file_get_contents('http://127.0.0.1:8080/radar.png');
        Storage::disk('public')->put('radar/radar.png', $contents);
    }
}
