<?php

namespace App\Repositories;

use App\Models\ReportGeofenceBongkarMuat;
use App\Repositories\BaseRepository;

class ReportGeofenceBongkarMuatRepository extends BaseRepository
{
    protected $fieldSearchable = [
        'ais_data_position_id',
        'geofence_id',
        'mmsi',
        'nama_kapal',
        'id_rkbm',
        'in',
        'out',
        'total_time'
    ];

    public function getFieldsSearchable(): array
    {
        return $this->fieldSearchable;
    }

    public function model(): string
    {
        return ReportGeofenceBongkarMuat::class;
    }
}
