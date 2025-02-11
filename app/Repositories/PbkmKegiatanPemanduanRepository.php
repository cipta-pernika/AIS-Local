<?php

namespace App\Repositories;

use App\Models\PbkmKegiatanPemanduan;
use App\Repositories\BaseRepository;

class PbkmKegiatanPemanduanRepository extends BaseRepository
{
    protected $fieldSearchable = [
        'nomor_spk_pandu',
        'no_pkk',
        'ais_data_vessel_id',
        'tanggal_spk_pandu',
        'nomor_imo',
        'nomor_spog',
        'npwp_agent',
        'nama_agent',
        'kode_dermaga_awal',
        'nama_dermaga_awal',
        'nama_dermaga_tujuan',
        'no_pandu',
        'nama_pandu',
        'nama_kapal',
        'bendera_kapal',
        'grt',
        'dwt',
        'loa',
        'tanggal_pandu_naik_kapal',
        'tanggal_pandu_turun_kapal',
        'jam_pandu_naik_kapal',
        'jam_pandu_turun_kapal',
        'biaya_layanan',
        'jumlah_pnbp'
    ];

    public function getFieldsSearchable(): array
    {
        return $this->fieldSearchable;
    }

    public function model(): string
    {
        return PbkmKegiatanPemanduan::class;
    }
}
