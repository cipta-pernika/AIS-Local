<?php

namespace Database\Seeders;

use App\Models\Identification;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class IndentificationSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Identification::create([
            'name' => 'At Anchor',
            'desc' => '',
        ]);
        Identification::create([
            'name' => 'Moored',
            'desc' => '',
        ]);
        Identification::create([
            'name' => 'Kapal Asing',
            'desc' => 'Mengelola lalu lintas kapal asing dan lokal dengan memastikan kepatuhan terhadap peraturan dan prosedur pelabuhan.',
        ]);
        Identification::create([
            'name' => 'Transhipment',
            'desc' => 'Memantau dan mengelola proses transhipment (pemindahan kargo dari satu kapal ke kapal lain) yang mungkin terjadi di pelabuhan.',
        ]);
        Identification::create([
            'name' => 'Bongkar Muat',
            'desc' => 'Memastikan efisiensi dan keamanan proses bongkar muat kargo dari dan ke kapal.',
        ]);
    }
}
