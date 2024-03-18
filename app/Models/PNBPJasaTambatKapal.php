<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PNBPJasaTambatKapal extends Model
{
    public $table = 'pnbp_jasa_tambat_kapal';

    public $fillable = [
        'gt',
        'etmal_hours',
        'tarif_domestik',
        'tarif_asing'
    ];

    protected $casts = [
        'gt' => 'decimal:2',
        'tarif_domestik' => 'decimal:2',
        'tarif_asing' => 'decimal:2'
    ];

    public static array $rules = [
        'gt' => 'required|numeric',
        'etmal_hours' => 'required',
        'tarif_domestik' => 'required|numeric',
        'tarif_asing' => 'required|numeric',
        'created_at' => 'nullable',
        'updated_at' => 'nullable'
    ];

    
}
