<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PNBPJasaLabuhKapal extends Model
{
    public $table = 'pnbp_jasa_labuh_kapals';

    public $fillable = [
        'ais_data_vessel_id',
        'gt',
        'kunjungan',
        'tarif_domestik',
        'tarif_asing'
    ];

    protected $casts = [
        'tarif_domestik' => 'decimal:2',
        'tarif_asing' => 'decimal:2'
    ];

    public static array $rules = [
        'ais_data_vessel_id' => 'nullable',
        'gt' => 'required',
        'kunjungan' => 'required',
        'tarif_domestik' => 'required|numeric',
        'tarif_asing' => 'required|numeric',
        'created_at' => 'nullable',
        'updated_at' => 'nullable'
    ];

    public function aisDataVessel(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(\App\Models\AisDataVessel::class, 'ais_data_vessel_id');
    }
}
