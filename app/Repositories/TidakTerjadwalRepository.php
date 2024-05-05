<?php

namespace App\Repositories;

use App\Models\TidakTerjadwal;
use App\Repositories\BaseRepository;

class TidakTerjadwalRepository extends BaseRepository
{
    protected $fieldSearchable = [
        'ais_data_vessel_id',
        'isPassing',
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
        return TidakTerjadwal::class;
    }
}
