<?php

namespace Database\Seeders;

use App\Models\AdsbDataAircraft;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Storage;

class AdsbDataAircraftSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $file = Storage::disk('local')->path('/json/basic-ac-db.json');
        $handle = fopen($file, 'r');

        if ($handle) {
            while (($line = fgets($handle)) !== false) {
                $aircraft = json_decode($line, true);

                if ($aircraft !== null) {
                    AdsbDataAircraft::updateOrCreate([
                        'manufacturer' => $aircraft['manufacturer'],
                        'model' => $aircraft['model'],
                        'registration' => $aircraft['reg'],
                        'ownop' => $aircraft['ownop'],
                        'callsign' => null,
                        'hex_ident' => strtoupper($aircraft['icao']),
                        'year' => $aircraft['year'],
                    ]);
                } else {
                    echo "Failed to decode JSON line: $line";
                }
            }

            fclose($handle);
        } else {
            echo "Failed to open JSON file.";
        }
    }
}
