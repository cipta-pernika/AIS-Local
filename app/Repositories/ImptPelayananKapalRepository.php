<?php

namespace App\Repositories;

use App\Models\ImptPelayananKapal;
use App\Repositories\BaseRepository;

class ImptPelayananKapalRepository extends BaseRepository
{
    protected $fieldSearchable = [
        'no_pkk',
        'ais_data_vessel_id',
        'nama_kapal',
        'gt',
        'nama_agen_pelayaran',
        'waktu_kedatangan',
        'waktu_keberangkatan',
        'posisi',
        'jumlah_biaya',
        'jumlah_pnbp',
        'date'
    ];

    public function getFieldsSearchable(): array
    {
        return $this->fieldSearchable;
    }

    public function model(): string
    {
        return ImptPelayananKapal::class;
    }
}
