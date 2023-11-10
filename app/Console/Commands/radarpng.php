<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Storage;

class radarpng extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'radarpng';

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
        $contents = file_get_contents('http://127.0.0.1:8160/radar.png');
        Storage::disk('public')->put('radar/radar.png', $contents);

        $response = Http::attach(
            'file', $contents, 'radar.png'
        )->post('http://172.16.172.8/api/radarpng');
        $this->line($response->body());
    }
}