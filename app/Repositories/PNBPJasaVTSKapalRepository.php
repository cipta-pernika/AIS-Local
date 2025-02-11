<?php

namespace App\Repositories;

use App\Models\PNBPJasaVTSKapal;
use App\Repositories\BaseRepository;

class PNBPJasaVTSKapalRepository extends BaseRepository
{
    protected $fieldSearchable = [
        'klasifikasi_besaran',
        'gt_kapal_from',
        'gt_kapal_to',
        'tarif_domestik',
        'tarif_asing'
    ];

    public function getFieldsSearchable(): array
    {
        return $this->fieldSearchable;
    }

    public function model(): string
    {
        return PNBPJasaVTSKapal::class;
    }
}
