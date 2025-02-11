<?php

namespace App\Repositories;

use App\Models\GeofenceType;
use App\Repositories\BaseRepository;

class GeofenceTypeRepository extends BaseRepository
{
    protected $fieldSearchable = [
        'name',
        'base_price',
        'uom',
        'vessel_type'
    ];

    public function getFieldsSearchable(): array
    {
        return $this->fieldSearchable;
    }

    public function model(): string
    {
        return GeofenceType::class;
    }
}
