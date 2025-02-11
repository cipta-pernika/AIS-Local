<?php

namespace App\Repositories;

use App\Models\MapSetting;
use App\Repositories\BaseRepository;

class MapSettingRepository extends BaseRepository
{
    protected $fieldSearchable = [
        'user_id',
        'distance_unit',
        'speed_unit',
        'breadcrumb',
        'breadcrumb_point',
        'time_zone',
        'coordinate_format'
    ];

    public function getFieldsSearchable(): array
    {
        return $this->fieldSearchable;
    }

    public function model(): string
    {
        return MapSetting::class;
    }
}
