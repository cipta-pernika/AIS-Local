<?php

namespace Database\Seeders;

use App\Models\RadarData;
use Carbon\Carbon;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class RadarDataSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // $faker = \Faker\Factory::create();

        // for ($i = 0; $i < 10; $i++) {
        //     DB::table('radar_datas')->insert([
        //         'sensor_data_id' => 1,
        //         'target_id' => $faker->uuid,
        //         'latitude' => $faker->latitude,
        //         'longitude' => $faker->longitude,
        //         'altitude' => $faker->optional()->randomFloat(2, 0, 10000),
        //         'speed' => $faker->optional()->randomFloat(2, 0, 100),
        //         'heading' => $faker->optional()->randomFloat(2, 0, 360),
        //         'course' => $faker->optional()->randomFloat(2, 0, 360),
        //         'range' => $faker->optional()->randomFloat(2, 0, 100),
        //         'bearing' => $faker->optional()->randomFloat(2, 0, 360),
        //         'timestamp' => $faker->dateTimeBetween('-1 year', 'now'),
        //         'created_at' => Carbon::now(),
        //         'updated_at' => Carbon::now(),
        //     ]);
        // }
        RadarData::create([
            'sensor_data_id' => 1,
            'target_id' => 'T289',
            'latitude' => -5.9032900,
            'longitude' => 106.0106800,
            'altitude' => 1,
            'speed' => 'TARGET1',
            'heading' => 1,
            'course' => 'TARGET1',
            'range' => 1,
            'bearing' => 'TARGET1',
            'timestamp' => 1,
            'created_at' => 'TARGET1',
            'updated_at' => 1,
        ]);
    }
}
