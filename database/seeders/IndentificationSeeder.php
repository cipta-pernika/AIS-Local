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
            'desc' => '',
        ]);
    }
}
