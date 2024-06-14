<?php

namespace App\Repositories;

use App\Models\PelindoBongkarMuat;
use App\Repositories\BaseRepository;

class PelindoBongkarMuatRepository extends BaseRepository
{
    protected $fieldSearchable = [
        'no_pkk',
        'ais_data_vessel_id',
        'nama_kapal',
        'nama_agent',
        'ppk',
        'gt_kapal',
        'dwt',
        'loa',
        'nama_dermaga',
        'rea_mulai_bm',
        'rea_selesai_bm',
        'jumlah_biaya',
        'jumlah_pnbp',
        'id_rkbm',
        'pbm',
        'kegiatan_bongkar_muat',
        'jenis_barang',
        'jumlah_barang',
        'rea_mulai_tambat',
        'rea_selesai_tambat',
        'created_at_pelindo',
        'image_mulai',
        'image_sedang',
        'image_selesai',
        'no_pkk_assign',
        'mmsi'
    ];

    public function getFieldsSearchable(): array
    {
        return $this->fieldSearchable;
    }

    public function model(): string
    {
        return PelindoBongkarMuat::class;
    }
}
