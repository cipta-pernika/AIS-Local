<?php

namespace App\Repositories;

use App\Models\Konsolidasi;
use App\Repositories\BaseRepository;

class KonsolidasiRepository extends BaseRepository
{
    protected $fieldSearchable = [
        'passing',
        'pandu_tervalidasi',
        'pandu_tidak_terjadwal',
        'pandu_terlambat',
        'bongkar_muat_tervalidasi',
        'bongkar_muat_tidak_terjadwal',
        'bongkar_muat_terlambat',
        'total_kapal'
    ];

    public function getFieldsSearchable(): array
    {
        return $this->fieldSearchable;
    }

    public function model(): string
    {
        return Konsolidasi::class;
    }
}
