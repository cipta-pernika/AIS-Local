<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PNBPJasaVTSKapalAsing extends Model
{
    public $table = 'pnbp_jasa_vts_kapal_asing';

    public $fillable = [
        'klasifikasi_besaran',
        'gt_kapal_from',
        'gt_kapal_to',
        'rumus',
        'variabel',
        'tarif_domestik',
        'tarif_asing'
    ];

    protected $casts = [
        'klasifikasi_besaran' => 'string',
        'rumus' => 'string',
        'variabel' => 'string',
        'tarif_domestik' => 'decimal:2',
        'tarif_asing' => 'decimal:2'
    ];

    public static array $rules = [
        'klasifikasi_besaran' => 'required|string|max:255',
        'gt_kapal_from' => 'nullable',
        'gt_kapal_to' => 'nullable',
        'rumus' => 'required|string|max:255',
        'variabel' => 'required|string|max:255',
        'tarif_domestik' => 'nullable|numeric',
        'tarif_asing' => 'nullable|numeric',
        'created_at' => 'nullable',
        'updated_at' => 'nullable'
    ];

    
}
