<?php

namespace App\Repositories;

use App\Models\Certificate;
use App\Repositories\BaseRepository;

class CertificateRepository extends BaseRepository
{
    protected $fieldSearchable = [
        'ais_data_vessel_id',
        'sertifikat',
        'tgl_terbit',
        'tgl_expired'
    ];

    public function getFieldsSearchable(): array
    {
        return $this->fieldSearchable;
    }

    public function model(): string
    {
        return Certificate::class;
    }
}
