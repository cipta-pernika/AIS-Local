<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PNBPJasaPengawasanBongkarMuat extends Model
{
    public $table = 'pnbp_jasa_pengawasan_bongkar_muat';

    public $fillable = [
        'jenis_komoditi',
        'tarif'
    ];

    protected $casts = [
        'jenis_komoditi' => 'string',
        'tarif' => 'decimal:2'
    ];

    public static array $rules = [
        'jenis_komoditi' => 'required|string|max:255',
        'tarif' => 'required|numeric',
        'created_at' => 'nullable',
        'updated_at' => 'nullable'
    ];

    
}
