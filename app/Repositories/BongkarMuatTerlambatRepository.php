<?php

namespace App\Repositories;

use App\Models\BongkarMuatTerlambat;
use App\Repositories\BaseRepository;

class BongkarMuatTerlambatRepository extends BaseRepository
{
    protected $fieldSearchable = [
        'ais_data_vessel_id',
        'id_rkbm',
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
        return BongkarMuatTerlambat::class;
    }
}
