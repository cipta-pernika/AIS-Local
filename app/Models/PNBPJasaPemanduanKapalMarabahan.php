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
        'rumus' => 'required|string|max:255',
        'variabel' => 'required|string|max:255',
        'tarif_tetap' => 'required|numeric',
        'created_at' => 'nullable',
        'updated_at' => 'nullable'
    ];

    
}
