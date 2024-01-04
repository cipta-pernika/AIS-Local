<?php

namespace App\Repositories;

use App\Models\Pelabuhan;
use App\Repositories\BaseRepository;

class PelabuhanRepository extends BaseRepository
{
    protected $fieldSearchable = [
        'name',
        'un_locode',
        'latitude',
        'longitude',
        'address'
    ];

    public function getFieldsSearchable(): array
    {
        return $this->fieldSearchable;
    }

    public function model(): string
    {
        return Pelabuhan::class;
    }
}
