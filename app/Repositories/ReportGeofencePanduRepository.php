<?php

namespace App\Repositories;

use App\Models\ReportGeofencePandu;
use App\Repositories\BaseRepository;

class ReportGeofencePanduRepository extends BaseRepository
{
    protected $fieldSearchable = [
        'ais_data_position_id',
        'geofence_id',
        'mmsi',
        'nama_kapal',
        'nomor_spk_pandu',
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
        return ReportGeofencePandu::class;
    }
}
