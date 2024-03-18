<?php

namespace App\Repositories;

use App\Models\PNBPJasaPengawasanBongkarMuat;
use App\Repositories\BaseRepository;

class PNBPJasaPengawasanBongkarMuatRepository extends BaseRepository
{
    protected $fieldSearchable = [
        'jenis_komoditi',
        'tarif'
    ];

    public function getFieldsSearchable(): array
    {
        return $this->fieldSearchable;
    }

    public function model(): string
    {
        return PNBPJasaPengawasanBongkarMuat::class;
    }
}
