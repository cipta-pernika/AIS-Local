<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class AssetSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Define sample data
        $data = [
            [
                'asset_name' => 'Asset 1',
                'asset_author' => 'Author 1',
                'asset_type' => 'Type 1',
                // Add other columns and their values here
            ],
            [
                'asset_name' => 'Asset 2',
                'asset_author' => 'Author 2',
                'asset_type' => 'Type 2',
                // Add other columns and their values here
            ],
            // Add more sample records as needed
        ];

        // Insert data into the 'assets' table
        DB::table('assets')->insert($data);
    }
}
