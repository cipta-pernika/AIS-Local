<?php

namespace App\Repositories;

use App\Models\ImptBongkarMuat;
use App\Repositories\BaseRepository;

class ImptBongkarMuatRepository extends BaseRepository
{
    protected $fieldSearchable = [
        'id_impt_bongkar_muat',
        'no_pkk',
        'rkbm',
        'ais_data_vessel_id',
        'nomor_registrasi_cargo',
        'nama_kapal',
        'nama_perusahaan',
        'pemilik_barang',
        'jenis',
        'jumlah_tonase',
        'jumlah_biaya',
        'jumlah_pnbp',
        'kegiatan',
        'tanggal_mulai',
        'tanggal_selesai',
        'date',
        'image_mulai',
        'image_sedang',
        'image_selesai',
        'image_mulai_2',
        'image_sedang_2',
        'image_selesai_2',
        'image_mulai_3',
        'image_sedang_3',
        'image_selesai_3',
        'no_pkk_assign',
        'mmsi'
    ];

    public function getFieldsSearchable(): array
    {
        return $this->fieldSearchable;
    }

    public function model(): string
    {
        return ImptBongkarMuat::class;
    }
}
