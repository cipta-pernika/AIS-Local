<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ImptPenggunaanAlat extends Model
{
    public $table = 'impt_penggunaan_alats';

    public $fillable = [
        'impt_source_id',
        'ais_data_vessel_id',
        'no_pkk',
        'nama_kapal',
        'nomor_te',
        'spog',
        'nama_floting_crane',
        'gt',
        'agen_perusahaan_te',
        'tanggal_mulai_kegiatan',
        'tanggal_selesai_kegiatan',
        'lama_penggunaaan',
        'jumlah_biaya',
        'jumlah_pnbp',
        'date'
    ];

    protected $casts = [
        'no_pkk' => 'string',
        'nama_kapal' => 'string',
        'nomor_te' => 'string',
        'spog' => 'string',
        'nama_floting_crane' => 'string',
        'gt' => 'string',
        'agen_perusahaan_te' => 'string',
        'tanggal_mulai_kegiatan' => 'datetime',
        'tanggal_selesai_kegiatan' => 'datetime',
        'lama_penggunaaan' => 'string',
        'date' => 'datetime'
    ];

    public static array $rules = [
        'impt_source_id' => 'required',
        'ais_data_vessel_id' => 'nullable',
        'no_pkk' => 'required|string|max:255',
        'nama_kapal' => 'nullable|string|max:255',
        'nomor_te' => 'nullable|string|max:255',
        'spog' => 'nullable|string|max:255',
        'nama_floting_crane' => 'nullable|string|max:255',
        'gt' => 'nullable|string|max:255',
        'agen_perusahaan_te' => 'nullable|string|max:255',
        'tanggal_mulai_kegiatan' => 'nullable',
        'tanggal_selesai_kegiatan' => 'nullable',
        'lama_penggunaaan' => 'nullable|string|max:255',
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
