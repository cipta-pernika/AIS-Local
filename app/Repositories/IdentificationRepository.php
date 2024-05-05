<?php

namespace App\Repositories;

use App\Models\Identification;
use App\Repositories\BaseRepository;

class IdentificationRepository extends BaseRepository
{
    protected $fieldSearchable = [
        'name',
        'desc'
    ];

    public function getFieldsSearchable(): array
    {
        return $this->fieldSearchable;
    }

    public function model(): string
    {
        return Identification::class;
    }
}
