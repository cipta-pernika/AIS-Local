<?php

namespace App\Repositories;

use App\Models\ImptPenggunaanAlatBongkarMuat;
use App\Repositories\BaseRepository;

class ImptPenggunaanAlatBongkarMuatRepository extends BaseRepository
{
    protected $fieldSearchable = [
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

    public function getFieldsSearchable(): array
    {
        return $this->fieldSearchable;
    }

    public function model(): string
    {
        return ImptPenggunaanAlatBongkarMuat::class;
    }
}
