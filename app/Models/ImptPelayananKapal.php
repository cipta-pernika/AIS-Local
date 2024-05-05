<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ImptPelayananKapal extends Model
{
    public $table = 'impt_pelayanan_kapals';

    public $fillable = [
        'no_pkk',
        'ais_data_vessel_id',
        'nama_kapal',
        'gt',
        'nama_agen_pelayaran',
        'waktu_kedatangan',
        'waktu_keberangkatan',
        'posisi',
        'jumlah_biaya',
        'jumlah_pnbp',
        'date',
        'mmsi',
    ];

    protected $casts = [
        'no_pkk' => 'string',
        'nama_kapal' => 'string',
        'gt' => 'string',
        'nama_agen_pelayaran' => 'string',
        'waktu_kedatangan' => 'datetime',
        'waktu_keberangkatan' => 'datetime',
        'posisi' => 'string',
        'date' => 'datetime'
    ];

    public static array $rules = [
        'no_pkk' => 'required|string|max:255',
        'ais_data_vessel_id' => 'nullable',
        'nama_kapal' => 'nullable|string|max:255',
        'gt' => 'nullable|string|max:255',
        'nama_agen_pelayaran' => 'nullable|string|max:255',
        'waktu_kedatangan' => 'nullable',
        'waktu_keberangkatan' => 'nullable',
        'posisi' => 'nullable|string|max:255',
        'jumlah_biaya' => 'nullable',
        'jumlah_pnbp' => 'nullable',
        'date' => 'nullable',
        'created_at' => 'nullable',
        'updated_at' => 'nullable'
    ];

    public function aisDataVessel(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(\App\Models\AisDataVessel::class, 'ais_data_vessel_id');
    }
}
