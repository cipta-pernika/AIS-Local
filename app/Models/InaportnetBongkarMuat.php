<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class InaportnetBongkarMuat extends Model
{
    public $table = 'inaportnet_bongkar_muats';

    protected $connection = 'mysql_second';

    public $fillable = [
        'id_rkbm',
        'pbm_kode',
        'no_pkk',
        'no_surat_keluar',
        'kade',
        'rencana_bongkar',
        'rencana_muat',
        'mulai_bongkar',
        'mulai_muat',
        'selesai_bongkar',
        'selesai_muat',
        'nomor_layanan_masuk',
        'nomor_layanan_sps',
        'nama_kapal',
        'gt_kapal',
        'panjang_kapal',
        'dwt',
        'siupal_pemilik',
        'siupal_operator',
        'bendera',
        'nama_perusahaan',
        'nomor_produk',
        'tipe_kapal',
        'pbm',
        'bongkar',
        'muat',
        'ais_data_vessel_id',
        'no_pkk_assign',
        'image_mulai',
        'image_sedang',
        'image_selesai',
        'image_mulai_2',
        'image_sedang_2',
        'image_selesai_2',
        'image_mulai_3',
        'image_sedang_3',
        'image_selesai_3',
        'actual_mulai_bongkar',
        'actual_mulai_muat',
        'actual_selesai_bongkar',
        'actual_selesai_muat',
        'mmsi',
        'tanggal_acuan'
    ];

    protected $casts = [
        'pbm_kode' => 'string',
        'no_pkk' => 'string',
        'no_surat_keluar' => 'string',
        'kade' => 'string',
        'rencana_bongkar' => 'date',
        'rencana_muat' => 'date',
        'mulai_bongkar' => 'date',
        'mulai_muat' => 'date',
        'selesai_bongkar' => 'date',
        'selesai_muat' => 'date',
        'nomor_layanan_masuk' => 'string',
        'nomor_layanan_sps' => 'string',
        'nama_kapal' => 'string',
        'siupal_pemilik' => 'string',
        'siupal_operator' => 'string',
        'bendera' => 'string',
        'nama_perusahaan' => 'string',
        'nomor_produk' => 'string',
        'tipe_kapal' => 'string',
        'pbm' => 'string',
        'bongkar' => 'string',
        'muat' => 'string'
    ];

    public static array $rules = [
        'id_rkbm' => 'required',
        'pbm_kode' => 'nullable|string|max:255',
        'no_pkk' => 'nullable|string|max:255',
        'no_surat_keluar' => 'nullable|string|max:255',
        'kade' => 'nullable|string|max:255',
        'rencana_bongkar' => 'nullable',
        'rencana_muat' => 'nullable',
        'mulai_bongkar' => 'nullable',
        'mulai_muat' => 'nullable',
        'selesai_bongkar' => 'nullable',
        'selesai_muat' => 'nullable',
        'nomor_layanan_masuk' => 'nullable|string|max:255',
        'nomor_layanan_sps' => 'nullable|string|max:255',
        'nama_kapal' => 'nullable|string|max:255',
        'gt_kapal' => 'nullable',
        'panjang_kapal' => 'nullable',
        'dwt' => 'nullable',
        'siupal_pemilik' => 'nullable|string|max:255',
        'siupal_operator' => 'nullable|string|max:255',
        'bendera' => 'nullable|string|max:255',
        'nama_perusahaan' => 'nullable|string|max:255',
        'nomor_produk' => 'nullable|string|max:255',
        'tipe_kapal' => 'nullable|string|max:255',
        'pbm' => 'nullable|string|max:255',
        'bongkar' => 'nullable|string',
        'muat' => 'nullable|string',
        'created_at' => 'nullable',
        'updated_at' => 'nullable'
    ];

    public function aisDataVessel(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(\App\Models\AisDataVessel::class, 'ais_data_vessel_id');
    }
}
