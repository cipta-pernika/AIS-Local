<?php

namespace App\Repositories;

use App\Models\MissionPlan;
use App\Repositories\BaseRepository;

class MissionPlanRepository extends BaseRepository
{
    protected $fieldSearchable = [
        'asset_id',
        'name',
        'ETD',
        'ATD',
        'ETA',
        'ATA',
        'route_plans',
        'captain',
        'muatan',
        'note',
        'status'
    ];

    public function getFieldsSearchable(): array
    {
        return $this->fieldSearchable;
    }

    public function model(): string
    {
        return MissionPlan::class;
    }
}
