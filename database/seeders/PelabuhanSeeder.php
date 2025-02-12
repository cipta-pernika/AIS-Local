<?php

namespace Database\Seeders;

use App\Models\Pelabuhan;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class PelabuhanSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $pelabuhan = [
            'name' => 'Banjarmasin',
            'un_locode' => 'IDBDJ',
            'latitude' => -3.3265939,
            'longitude' => 114.559263,
            'address' => 'Jl. Barito Hilir Trisakti No. 6, Banjarmasin, Kalimantan Selatan - 70119'
        ];

        if (DB::getDriverName() == 'mongodb') {
            DB::connection('mongodb')
                ->selectCollection('pelabuhans')
                ->insertOne($pelabuhan);
        } else {
            Pelabuhan::create($pelabuhan);
        }
    }
}
