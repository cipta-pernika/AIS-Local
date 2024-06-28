<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class InaportnetPergerakanKapal extends Model
{
    public $table = 'inaportnet_pergerakan_kapals';

    protected $connection = 'mysql_second';

    public $fillable = [
        'no_pkk',
        'ais_data_vessel_id',
        'nama_kapal',
        'jenis_layanan',
        'nama_negara',
        'tipe_kapal',
        'nama_perusahaan',
        'tgl_tiba',
        'tgl_brangkat',
        'bendera',
        'gt_kapal',
        'dwt',
        'no_imo',
        'call_sign',
        'nakhoda',
        'jenis_trayek',
        'pelabuhan_asal',
        'pelabuhan_tujuan',
        'lokasi_lambat_labuh',
        'waktu_respon',
        'nomor_spog',
        'no_pkk_assign',
        'mmsi',
        'image_mulai',
        'image_sedang',
        'image_selesai',
        'image_mulai_2',
        'image_sedang_2',
        'image_selesai_2',
        'image_mulai_3',
        'image_sedang_3',
        'image_selesai_3',
    ];

    protected $casts = [
        'no_pkk' => 'string',
        'nama_kapal' => 'string',
        'jenis_layanan' => 'string',
        'nama_negara' => 'string',
        'tipe_kapal' => 'string',
        'nama_perusahaan' => 'string',
        'tgl_tiba' => 'string',
        'tgl_brangkat' => 'string',
        'bendera' => 'string',
        'no_imo' => 'string',
        'call_sign' => 'string',
        'nakhoda' => 'string',
        'jenis_trayek' => 'string',
        'pelabuhan_asal' => 'string',
        'pelabuhan_tujuan' => 'string',
        'lokasi_lambat_labuh' => 'string',
        'waktu_respon' => 'string',
        'nomor_spog' => 'string'
    ];

    public static array $rules = [
        'no_pkk' => 'required|string|max:255',
        'ais_data_vessel_id' => 'nullable',
        'nama_kapal' => 'nullable|string|max:255',
        'jenis_layanan' => 'nullable|string|max:255',
        'nama_negara' => 'nullable|string|max:255',
        'tipe_kapal' => 'nullable|string|max:255',
        'nama_perusahaan' => 'nullable|string|max:255',
        'tgl_tiba' => 'nullable|string|max:255',
        'tgl_brangkat' => 'nullable|string|max:255',
        'bendera' => 'nullable|string|max:255',
        'gt_kapal' => 'nullable',
        'dwt' => 'nullable',
        'no_imo' => 'nullable|string|max:255',
        'call_sign' => 'nullable|string|max:255',
        'nakhoda' => 'nullable|string|max:255',
        'jenis_trayek' => 'nullable|string|max:255',
        'pelabuhan_asal' => 'nullable|string|max:255',
        'pelabuhan_tujuan' => 'nullable|string|max:255',
        'lokasi_lambat_labuh' => 'nullable|string|max:255',
        'waktu_respon' => 'nullable|string|max:255',
        'nomor_spog' => 'nullable|string|max:255',
        'created_at' => 'nullable',
        'updated_at' => 'nullable'
    ];

    public function aisDataVessel(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(\App\Models\AisDataVessel::class, 'ais_data_vessel_id');
    }

    public function selectPost($postId)
    {
        dd($postId);
        // Handle the select-post action here
        // For example, dispatch an event, update data, etc.
    }

    // public function assignId(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    // {
    //     return $this->belongsTo(\App\Models\AisDataVessel::class, 'no_pkk_assign', 'no_pkk');
    // }

    public function assignId(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(\App\Models\AisDataVessel::class, 'no_pkk', 'no_pkk');
    }
}
