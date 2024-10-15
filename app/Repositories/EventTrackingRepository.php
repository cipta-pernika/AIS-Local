<?php

namespace App\Repositories;

use App\Models\EventTracking;
use App\Repositories\BaseRepository;

class EventTrackingRepository extends BaseRepository
{
    protected $fieldSearchable = [
        'asset_id',
        'event_id',
        'ais_data_position_id',
        'notes',
        'mmsi',
        'ship_name'
    ];

    public function getFieldsSearchable(): array
    {
        return $this->fieldSearchable;
    }

    public function model(): string
    {
        return EventTracking::class;
    }
}
