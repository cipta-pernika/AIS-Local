<?php

namespace App\Repositories;

use App\Models\ReportGeofence;
use App\Repositories\BaseRepository;

class ReportGeofenceRepository extends BaseRepository
{
    protected $fieldSearchable = [
        'event_id',
        'ais_data_position_id',
        'geofence_id',
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
        return ReportGeofence::class;
    }
}
