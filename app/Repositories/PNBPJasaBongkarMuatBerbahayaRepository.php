<?php

namespace App\Repositories;

use App\Models\PNBPJasaBongkarMuatBerbahaya;
use App\Repositories\BaseRepository;

class PNBPJasaBongkarMuatBerbahayaRepository extends BaseRepository
{
    protected $fieldSearchable = [
        'klasifikasi_barang',
        'tarif'
    ];

    public function getFieldsSearchable(): array
    {
        return $this->fieldSearchable;
    }

    public function model(): string
    {
        return PNBPJasaBongkarMuatBerbahaya::class;
    }
}
