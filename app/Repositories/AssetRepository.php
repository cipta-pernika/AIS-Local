<?php

namespace App\Repositories;

use App\Models\Asset;
use App\Repositories\BaseRepository;

class AssetRepository extends BaseRepository
{
    protected $fieldSearchable = [
        'asset_name',
        'asset_author',
        'asset_type',
        'asset_owner',
        'mmsi',
        'callsign',
        'imo',
        'image',
        'kapasitas_muatan',
        'panjang',
        'lebar',
        'lebar_lambung',
        'tinggi_geladak',
        'mesin_pengerak',
        'max_speed',
        'kapasitas_awak_kapal',
        'kapasitas_pasukan',
        'kapasitas_tangki_bbm',
        'kapasitas_air_tawar',
        'kapasitas_jarak_jelajah',
        'kapasitas_dead_weight',
        'muatan_tank',
        'muatan_transporter',
        'muatan_helikopter',
        'muatan_sepeda_motor',
        'muatan_buldozer',
        'konstruksi',
        'profil',
        'sarat_kapal',
        'berat_benam'
    ];

    public function getFieldsSearchable(): array
    {
        return $this->fieldSearchable;
    }

    public function model(): string
    {
        return Asset::class;
    }
}
