<?php

namespace App\Repositories;

use App\Models\Tracking;
use App\Repositories\BaseRepository;

class TrackingRepository extends BaseRepository
{
    protected $fieldSearchable = [
        'asset_id',
        'latitude',
        'longitude',
        'altitude',
        'velocity',
        'heading',
        'event_id',
        'bat_lvl',
        'signal',
        'timestamp',
        'data_flow_id',
        'engine_rpm_id',
        'bat_hours',
        'satellite',
        'location',
        'orbcomm_id'
    ];

    public function getFieldsSearchable(): array
    {
        return $this->fieldSearchable;
    }

    public function model(): string
    {
        return Tracking::class;
    }
}
