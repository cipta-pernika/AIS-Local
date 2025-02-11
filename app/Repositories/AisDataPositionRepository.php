<?php

namespace App\Repositories;

use App\Models\AisDataPosition;
use App\Repositories\BaseRepository;

class AisDataPositionRepository extends BaseRepository
{
    protected $fieldSearchable = [
        'sensor_data_id',
        'vessel_id',
        'latitude',
        'longitude',
        'speed',
        'course',
        'heading',
        'navigation_status',
        'turning_rate',
        'turning_direction',
        'timestamp',
        'distance',
        'is_inside_geofence',
        'is_geofence'
    ];

    public function getFieldsSearchable(): array
    {
        return $this->fieldSearchable;
    }

    public function model(): string
    {
        return AisDataPosition::class;
    }
}
