<?php

namespace App\Repositories;

use App\Models\PNBPJasaPemanduanKapalTrisakti;
use App\Repositories\BaseRepository;

class PNBPJasaPemanduanKapalTrisaktiRepository extends BaseRepository
{
    protected $fieldSearchable = [
        'jenis',
        'rumus',
        'variabel',
        'tarif_tetap'
    ];

    public function getFieldsSearchable(): array
    {
        return $this->fieldSearchable;
    }

    public function model(): string
    {
        return PNBPJasaPemanduanKapalTrisakti::class;
    }
}
