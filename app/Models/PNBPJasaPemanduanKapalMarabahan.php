<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PNBPJasaPemanduanKapalMarabahan extends Model
{
    public $table = 'pnbp_pemanduan_kapal_marabahan';

    public $fillable = [
        'rumus',
        'variabel',
        'tarif_tetap'
    ];

    protected $casts = [
        'rumus' => 'string',
        'variabel' => 'string',
        'tarif_tetap' => 'decimal:2'
    ];

    public static array $rules = [
        'rumus' => 'nullable|string|max:255',
        'variabel' => 'nullable|string|max:255',
        'tarif_tetap' => 'nullable|numeric',
        'created_at' => 'nullable',
        'updated_at' => 'nullable'
    ];

    
}
