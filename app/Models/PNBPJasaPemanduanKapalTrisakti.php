<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PNBPJasaPemanduanKapalTrisakti extends Model
{
    public $table = 'pnbp_pemanduan_kapal_trisakti';

    public $fillable = [
        'jenis',
        'rumus',
        'variabel',
        'tarif_tetap'
    ];

    protected $casts = [
        'jenis' => 'string',
        'rumus' => 'string',
        'variabel' => 'string',
        'tarif_tetap' => 'decimal:2'
    ];

    public static array $rules = [
        'jenis' => 'nullable|string|max:255',
        'rumus' => 'nullable|string|max:255',
        'variabel' => 'nullable|string|max:255',
        'tarif_tetap' => 'nullable|numeric',
        'created_at' => 'nullable',
        'updated_at' => 'nullable'
    ];

    
}
