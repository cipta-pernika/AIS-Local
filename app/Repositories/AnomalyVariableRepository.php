<?php

namespace App\Repositories;

use App\Models\AnomalyVariable;
use App\Repositories\BaseRepository;

class AnomalyVariableRepository extends BaseRepository
{
    protected $fieldSearchable = [
        'name',
        'description',
        'unit',
        'type',
        'value'
    ];

    public function getFieldsSearchable(): array
    {
        return $this->fieldSearchable;
    }

    public function model(): string
    {
        return AnomalyVariable::class;
    }
}
