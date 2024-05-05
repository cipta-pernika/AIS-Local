<?php

namespace App\Repositories;

use App\Models\PanduTerlambat;
use App\Repositories\BaseRepository;

class PanduTerlambatRepository extends BaseRepository
{
    protected $fieldSearchable = [
        'ais_data_vessel_id',
        'nomor_spk_pandu',
        'geofence_id',
        'ais_data_position_id',
        'report_geofence_id'
    ];

    public function getFieldsSearchable(): array
    {
        return $this->fieldSearchable;
    }

    public function model(): string
    {
        return PanduTerlambat::class;
    }
}
