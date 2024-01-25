<?php

namespace App\Repositories;

use App\Models\Location;
use App\Repositories\BaseRepository;

class LocationRepository extends BaseRepository
{
    protected $fieldSearchable = [
        'name',
        'location_type_id',
        'latitude',
        'longitude'
    ];

    public function getFieldsSearchable(): array
    {
        return $this->fieldSearchable;
    }

    public function model(): string
    {
        return Location::class;
    }
}
