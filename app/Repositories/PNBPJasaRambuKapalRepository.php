<?php

namespace App\Repositories;

use App\Models\PNBPJasaRambuKapal;
use App\Repositories\BaseRepository;

class PNBPJasaRambuKapalRepository extends BaseRepository
{
    protected $fieldSearchable = [
        'trayek',
        'jenis_kapal',
        'gt',
        'tarif_domestik',
        'tarif_asing',
        'kurs'
    ];

    public function getFieldsSearchable(): array
    {
        return $this->fieldSearchable;
    }

    public function model(): string
    {
        return PNBPJasaRambuKapal::class;
    }
}
