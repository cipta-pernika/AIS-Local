<?php

namespace App\Repositories;

use App\Models\PNBPJasaBarang;
use App\Repositories\BaseRepository;

class PNBPJasaBarangRepository extends BaseRepository
{
    protected $fieldSearchable = [
        'rumus',
        'tarif_domestik',
        'tarif_asing'
    ];

    public function getFieldsSearchable(): array
    {
        return $this->fieldSearchable;
    }

    public function model(): string
    {
        return PNBPJasaBarang::class;
    }
}
