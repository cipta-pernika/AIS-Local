<?php

namespace App\Repositories;

use App\Models\AisDataAnomaly;
use App\Repositories\BaseRepository;

class AisDataAnomalyRepository extends BaseRepository
{
    protected $fieldSearchable = [
        'ais_data_position_id',
        'anomaly_type',
        'anomaly_description'
    ];

    public function getFieldsSearchable(): array
    {
        return $this->fieldSearchable;
    }

    public function model(): string
    {
        return AisDataAnomaly::class;
    }
}
