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
        $this->call([DataloggerSeeder::class, SensorSeeder::class, UserSeeder::class]);
        $this->call(SensorDatasTableSeeder::class);
        $this->call(AisDataVesselsTableSeeder::class);
        $this->call(AisDataPositionsTableSeeder::class);
    }
}
