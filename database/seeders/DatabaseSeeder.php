<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call([DatalogSeeder::class, SensorSeeder::class, UserSeeder::class]);
        $this->call([
            // RadarDataSeeder::class,
            LocationTypeSeeder::class,
            LocationSeeder::class,




            //paling akhir
            AdsbDataAircraftSeeder::class
        ]);
    }
}
