<?php

namespace App\Repositories;

use App\Models\InaportnetPergerakanKapal;
use App\Repositories\BaseRepository;

class InaportnetPergerakanKapalRepository extends BaseRepository
{
    protected $fieldSearchable = [
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
        'nomor_spog'
    ];

    public function getFieldsSearchable(): array
    {
        return $this->fieldSearchable;
    }

    public function model(): string
    {
        return InaportnetPergerakanKapal::class;
    }
}
