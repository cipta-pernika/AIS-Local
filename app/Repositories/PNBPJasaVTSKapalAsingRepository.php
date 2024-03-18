<?php

namespace App\Repositories;

use App\Models\PNBPJasaVTSKapalAsing;
use App\Repositories\BaseRepository;

class PNBPJasaVTSKapalAsingRepository extends BaseRepository
{
    protected $fieldSearchable = [
        'klasifikasi_besaran',
        'gt_kapal_from',
        'gt_kapal_to',
        'rumus',
        'variabel',
        'tarif_domestik',
        'tarif_asing'
    ];

    public function getFieldsSearchable(): array
    {
        return $this->fieldSearchable;
    }

    public function model(): string
    {
        return PNBPJasaVTSKapalAsing::class;
    }
}
