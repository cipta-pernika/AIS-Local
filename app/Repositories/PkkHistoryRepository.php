<?php

namespace App\Repositories;

use App\Models\PkkHistory;
use App\Repositories\BaseRepository;

class PkkHistoryRepository extends BaseRepository
{
    protected $fieldSearchable = [
        'ais_data_vessel_id',
        'no_pkk'
    ];

    public function getFieldsSearchable(): array
    {
        return $this->fieldSearchable;
    }

    public function model(): string
    {
        return PkkHistory::class;
    }
}
