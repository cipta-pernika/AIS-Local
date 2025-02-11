<?php

namespace App\Repositories;

use App\Models\PkkAssignHistory;
use App\Repositories\BaseRepository;

class PkkAssignHistoryRepository extends BaseRepository
{
    protected $fieldSearchable = [
        'ais_data_vessel_id',
        'no_pkk',
        'no_pkk_assign',
        'nama_perusahaan'
    ];

    public function getFieldsSearchable(): array
    {
        return $this->fieldSearchable;
    }

    public function model(): string
    {
        return PkkAssignHistory::class;
    }
}
