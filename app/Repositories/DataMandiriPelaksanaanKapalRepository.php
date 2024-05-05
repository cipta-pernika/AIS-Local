<?php

namespace App\Repositories;

use App\Models\DataMandiriPelaksanaanKapal;
use App\Repositories\BaseRepository;

class DataMandiriPelaksanaanKapalRepository extends BaseRepository
{
    protected $fieldSearchable = [
        'ais_data_vessel_id',
        'inaportnet_bongkar_muat_id',
        'inaportnet_pergerakan_kapal_id',
        'impt_pelayanan_kapal_id',
        'impt_penggunaan_alat_id',
        'pbkm_kegiatan_pemanduan_id',
        'isPassing',
        'isPandu',
        'isBongkarMuat',
        'geofence_id',
        'ais_data_position_id',
        'report_geofence_id'
    ];

    public function getFieldsSearchable(): array
    {
        return $this->fieldSearchable;
    }

    public function model(): string
    {
        return DataMandiriPelaksanaanKapal::class;
    }
}
