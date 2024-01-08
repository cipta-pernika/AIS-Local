<?php

namespace App\Repositories;

use App\Models\InaportnetBongkarMuat;
use App\Repositories\BaseRepository;

class InaportnetBongkarMuatRepository extends BaseRepository
{
    protected $fieldSearchable = [
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
        'muat'
    ];

    public function getFieldsSearchable(): array
    {
        return $this->fieldSearchable;
    }

    public function model(): string
    {
        return InaportnetBongkarMuat::class;
    }
}
