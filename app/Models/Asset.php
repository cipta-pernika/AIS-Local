<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Asset extends Model
{
    public $table = 'assets';

    public $fillable = [
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

    protected $casts = [
        'asset_name' => 'string',
        'asset_author' => 'string',
        'asset_type' => 'string',
        'asset_owner' => 'string',
        'mmsi' => 'string',
        'callsign' => 'string',
        'imo' => 'string',
        'image' => 'string',
        'panjang' => 'string',
        'lebar' => 'string',
        'lebar_lambung' => 'string',
        'tinggi_geladak' => 'string',
        'mesin_pengerak' => 'string',
        'max_speed' => 'string',
        'kapasitas_awak_kapal' => 'string',
        'kapasitas_pasukan' => 'string',
        'kapasitas_tangki_bbm' => 'string',
        'kapasitas_air_tawar' => 'string',
        'kapasitas_jarak_jelajah' => 'string',
        'kapasitas_dead_weight' => 'string',
        'muatan_tank' => 'string',
        'muatan_transporter' => 'string',
        'muatan_helikopter' => 'string',
        'muatan_sepeda_motor' => 'string',
        'muatan_buldozer' => 'string',
        'konstruksi' => 'string',
        'profil' => 'string',
        'sarat_kapal' => 'string',
        'berat_benam' => 'string'
    ];

    public static array $rules = [
        'asset_name' => 'required|string|max:255',
        'asset_author' => 'required|string|max:255',
        'asset_type' => 'required|string|max:255',
        'asset_owner' => 'nullable|string|max:255',
        'mmsi' => 'nullable|string|max:255',
        'callsign' => 'nullable|string|max:255',
        'imo' => 'nullable|string|max:255',
        'image' => 'nullable|string|max:255',
        'kapasitas_muatan' => 'nullable',
        'panjang' => 'nullable|string|max:255',
        'lebar' => 'nullable|string|max:255',
        'lebar_lambung' => 'nullable|string|max:255',
        'tinggi_geladak' => 'nullable|string|max:255',
        'mesin_pengerak' => 'nullable|string|max:255',
        'max_speed' => 'nullable|string|max:255',
        'kapasitas_awak_kapal' => 'nullable|string|max:255',
        'kapasitas_pasukan' => 'nullable|string|max:255',
        'kapasitas_tangki_bbm' => 'nullable|string|max:255',
        'kapasitas_air_tawar' => 'nullable|string|max:255',
        'kapasitas_jarak_jelajah' => 'nullable|string|max:255',
        'kapasitas_dead_weight' => 'nullable|string|max:255',
        'muatan_tank' => 'nullable|string|max:255',
        'muatan_transporter' => 'nullable|string|max:255',
        'muatan_helikopter' => 'nullable|string|max:255',
        'muatan_sepeda_motor' => 'nullable|string|max:255',
        'muatan_buldozer' => 'nullable|string|max:255',
        'konstruksi' => 'nullable|string|max:255',
        'profil' => 'nullable|string|max:255',
        'sarat_kapal' => 'nullable|string|max:255',
        'berat_benam' => 'nullable|string|max:255',
        'deleted_at' => 'nullable',
        'created_at' => 'nullable',
        'updated_at' => 'nullable'
    ];

    public function aisDataVessel()
    {
        return $this->hasOne(AisDataVessel::class, 'mmsi', 'mmsi');
    }
}
