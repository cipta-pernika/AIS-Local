<?php

namespace App\Repositories;

use App\Models\PNBPJasaLabuhKapal;
use App\Repositories\BaseRepository;

class PNBPJasaLabuhKapalRepository extends BaseRepository
{
    protected $fieldSearchable = [
        'ais_data_vessel_id',
        'gt',
        'kunjungan',
        'tarif_domestik',
        'tarif_asing'
    ];

    public function getFieldsSearchable(): array
    {
        return $this->fieldSearchable;
    }

    public function model(): string
    {
        return PNBPJasaLabuhKapal::class;
    }
}
