<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PNBPJasaBarang extends Model
{
    public $table = 'pnbp_jasa_barang';

    public $fillable = [
        'rumus',
        'tarif_domestik',
        'tarif_asing'
    ];

    protected $casts = [
        'rumus' => 'string',
        'tarif_domestik' => 'decimal:2',
        'tarif_asing' => 'decimal:2'
    ];

    public static array $rules = [
        'rumus' => 'nullable|string|max:255',
        'tarif_domestik' => 'nullable|numeric',
        'tarif_asing' => 'nullable|numeric',
        'created_at' => 'nullable',
        'updated_at' => 'nullable'
    ];

    
}
