<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Konsolidasi extends Model
{
    public $table = 'konsolidasis';

    public $fillable = [
        'passing',
        'pandu_tervalidasi',
        'pandu_tidak_terjadwal',
        'pandu_terlambat',
        'bongkar_muat_tervalidasi',
        'bongkar_muat_tidak_terjadwal',
        'bongkar_muat_terlambat',
        'total_kapal'
    ];

    protected $casts = [
        
    ];

    public static array $rules = [
        'passing' => 'required',
        'pandu_tervalidasi' => 'required',
        'pandu_tidak_terjadwal' => 'required',
        'pandu_terlambat' => 'required',
        'bongkar_muat_tervalidasi' => 'required',
        'bongkar_muat_tidak_terjadwal' => 'required',
        'bongkar_muat_terlambat' => 'required',
        'total_kapal' => 'required',
        'created_at' => 'nullable',
        'updated_at' => 'nullable'
    ];

    
}
