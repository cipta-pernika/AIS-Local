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
            SensorDatasTableSeeder::class,
            AisDataVesselsTableSeeder::class,
            AisDataPositionsTableSeeder::class,
            RadarDataSeeder::class,
        ]);
        $this->call(AdsbDataAircraftsTableSeeder::class);
        $this->call(AdsbDataFlightsTableSeeder::class);
        $this->call(AdsbDataPositionsTableSeeder::class);
        $this->call(SensorDatasTableSeeder::class);
    }
}
