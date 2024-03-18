<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PNBPJasaBongkarMuatBerbahaya extends Model
{
    public $table = 'pnbp_bongkar_muat_barang_berbahaya';

    public $fillable = [
        'klasifikasi_barang',
        'tarif'
    ];

    protected $casts = [
        'klasifikasi_barang' => 'string',
        'tarif' => 'decimal:2'
    ];

    public static array $rules = [
        'klasifikasi_barang' => 'required|string|max:255',
        'tarif' => 'required|numeric',
        'created_at' => 'nullable',
        'updated_at' => 'nullable'
    ];

    
}
