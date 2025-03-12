<?php

namespace Database\Seeders;

use App\Models\Identification;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class IndentificationSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $identifications = [
            [
                'name' => 'At Anchor',
                'desc' => '',
            ],
            [
                'name' => 'Moored',
                'desc' => '',
            ],
            [
                'name' => 'Kapal Asing',
                'desc' => 'Mengelola lalu lintas kapal asing dan lokal dengan memastikan kepatuhan terhadap peraturan dan prosedur pelabuhan.',
            ],
            [
                'name' => 'Transhipment',
                'desc' => 'Memantau dan mengelola proses transhipment (pemindahan kargo dari satu kapal ke kapal lain) yang mungkin terjadi di pelabuhan.',
            ],
            [
                'name' => 'Bongkar Muat',
                'desc' => 'Memastikan efisiensi dan keamanan proses bongkar muat kargo dari dan ke kapal.',
            ]
        ];

        if (DB::getDriverName() == 'mongodb') {
            foreach ($identifications as $identification) {
                DB::connection('mongodb')
                    ->selectCollection('identifications')
                    ->insertOne($identification);
            }
        } else {
            foreach ($identifications as $identification) {
                Identification::create($identification);
            }
        }
    }
}
