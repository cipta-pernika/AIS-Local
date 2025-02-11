<?php

namespace App\Repositories;

use App\Models\PNBPJasaTambatKapal;
use App\Repositories\BaseRepository;

class PNBPJasaTambatKapalRepository extends BaseRepository
{
    protected $fieldSearchable = [
        'gt',
        'etmal_hours',
        'tarif_domestik',
        'tarif_asing'
    ];

    public function getFieldsSearchable(): array
    {
        return $this->fieldSearchable;
    }

    public function model(): string
    {
        return PNBPJasaTambatKapal::class;
    }
}
