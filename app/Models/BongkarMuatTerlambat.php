<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class BongkarMuatTerlambat extends Model
{
    public $table = 'bongkar_muat_terlambats';

    public $fillable = [
        'ais_data_vessel_id',
        'id_rkbm',
        'geofence_id',
        'ais_data_position_id',
        'report_geofence_id',
        'inaportnet_bongkar_muat_id',
        'inaportnet_pergerakan_kapal_id',
        'impt_pelayanan_kapal_id',
        'impt_penggunaan_alat_id',
        'pbkm_kegiatan_pemanduan_id',
    ];

    protected $casts = [
        'id_rkbm' => 'string'
    ];

    public static array $rules = [
        'ais_data_vessel_id' => 'nullable',
        'id_rkbm' => 'nullable|string|max:255',
        'geofence_id' => 'nullable',
        'ais_data_position_id' => 'nullable',
        'report_geofence_id' => 'nullable',
        'created_at' => 'nullable',
        'updated_at' => 'nullable',
        'deleted_at' => 'nullable'
    ];

    public function aisDataPosition(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(\App\Models\AisDataPosition::class, 'ais_data_position_id');
    }

    public function aisDataVessel(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(\App\Models\AisDataVessel::class, 'ais_data_vessel_id');
    }

    public function geofence(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(\App\Models\Geofence::class, 'geofence_id');
    }

    public function reportGeofence(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(\App\Models\ReportGeofence::class, 'report_geofence_id');
    }



    public function imptPelayananKapal(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(\App\Models\ImptPelayananKapal::class, 'impt_pelayanan_kapal_id');
    }

    public function imptPenggunaanAlat(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(\App\Models\ImptPenggunaanAlat::class, 'impt_penggunaan_alat_id');
    }

    public function inaportnetBongkarMuat(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(\App\Models\InaportnetBongkarMuat::class, 'inaportnet_bongkar_muat_id');
    }

    public function pbkmKegiatanPemanduan(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(\App\Models\PbkmKegiatanPemanduan::class, 'pbkm_kegiatan_pemanduan_id');
    }

    public function reportGeofenceBongkarMuat(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(\App\Models\ReportGeofenceBongkarMuat::class, 'report_geofence_bongkar_muat_id');
    }
}
