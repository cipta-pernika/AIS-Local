<?php

namespace App\Repositories;

use App\Models\GeofenceImage;
use App\Repositories\BaseRepository;

class GeofenceImageRepository extends BaseRepository
{
    protected $fieldSearchable = [
        'image_path',
        'mmsi',
        'geofence_id',
        'vessel_name',
        'timestamp'
    ];

    public function getFieldsSearchable(): array
    {
        return $this->fieldSearchable;
    }

    public function model(): string
    {
        return GeofenceImage::class;
    }
}
