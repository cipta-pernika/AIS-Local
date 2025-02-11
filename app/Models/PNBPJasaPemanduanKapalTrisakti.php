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
        'jenis' => 'required|string|max:255',
        'rumus' => 'required|string|max:255',
        'variabel' => 'required|string|max:255',
        'tarif_tetap' => 'required|numeric',
        'created_at' => 'nullable',
        'updated_at' => 'nullable'
    ];

    
}
