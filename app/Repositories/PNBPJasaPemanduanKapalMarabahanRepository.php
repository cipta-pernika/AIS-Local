<?php

namespace App\Repositories;

use App\Models\PNBPJasaPemanduanKapalMarabahan;
use App\Repositories\BaseRepository;

class PNBPJasaPemanduanKapalMarabahanRepository extends BaseRepository
{
    protected $fieldSearchable = [
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
        return PNBPJasaPemanduanKapalMarabahan::class;
    }
}
