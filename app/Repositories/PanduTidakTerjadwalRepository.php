<?php

namespace App\Repositories;

use App\Models\PanduTidakTerjadwal;
use App\Repositories\BaseRepository;

class PanduTidakTerjadwalRepository extends BaseRepository
{
    protected $fieldSearchable = [
        'ais_data_vessel_id',
        'isPassing',
        'geofence_id',
        'nomor_spk_pandu',
        'ais_data_position_id',
        'report_geofence_id'
    ];

    public function getFieldsSearchable(): array
    {
        return $this->fieldSearchable;
    }

    public function model(): string
    {
        return PanduTidakTerjadwal::class;
    }
}
