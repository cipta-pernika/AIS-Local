<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PNBPJasaRambuKapal extends Model
{
    public $table = 'pnbp_jasa_rambu_kapal';

    public $fillable = [
        'trayek',
        'jenis_kapal',
        'gt',
        'tarif_domestik',
        'tarif_asing',
        'kurs'
    ];

    protected $casts = [
        'trayek' => 'string',
        'jenis_kapal' => 'string',
        'gt' => 'decimal:2',
        'tarif_domestik' => 'decimal:2',
        'tarif_asing' => 'decimal:2',
        'kurs' => 'decimal:2'
    ];

    public static array $rules = [
        'trayek' => 'nullable|string|max:255',
        'jenis_kapal' => 'nullable|string|max:255',
        'gt' => 'nullable|numeric',
        'tarif_domestik' => 'nullable|numeric',
        'tarif_asing' => 'nullable|numeric',
        'kurs' => 'nullable|numeric',
        'created_at' => 'nullable',
        'updated_at' => 'nullable'
    ];

    
}
