<?php

namespace App\Repositories;

use App\Models\Pelabuhan;
use App\Repositories\BaseRepository;

class PelabuhanRepository extends BaseRepository
{
    protected $fieldSearchable = [
        'name',
        'un_locode',
        'latitude',
        'longitude',
        'radius',
        'address',
        'penanggung_jawab',
        'no_izin_pengoperasian',
        'tgl_izin_pengoperasian',
        'penerbit_izin_pengoperasian',
        'no_perjanjian_sewa_perairan',
        'tgl_sewa_perairan',
        'luas_perairan',
        'jasa_pengunaan_perairan',
        'keterangan',
        'masa_berlaku_izin_operasi',
        'masa_berlaku_perjanjian_sewa_perairan'
    ];

    public function getFieldsSearchable(): array
    {
        return $this->fieldSearchable;
    }

    public function model(): string
    {
        return Pelabuhan::class;
    }
}
