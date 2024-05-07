<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PanduTerlambat extends Model
{
    public $table = 'pandu_terlambats';

    public $fillable = [
        'ais_data_vessel_id',
        'nomor_spk_pandu',
        'geofence_id',
        'ais_data_position_id',
        'tanggal_spk_pandu',
        'report_geofence_id',
        'inaportnet_bongkar_muat_id',
        'inaportnet_pergerakan_kapal_id',
        'impt_pelayanan_kapal_id',
        'impt_penggunaan_alat_id',
        'pbkm_kegiatan_pemanduan_id',
        'vessel_name',
        'mmsi',
        'pnbp_jasa_labuh_kapal',
        'pnbp_jasa_vts_kapal_domestik',
        'pnbp_jasa_vts_kapal_asing',
        'pnbp_jasa_pemanduan_penundaan_marabahan',
        'pnbp_jasa_barang',
        'pnbp_jasa_pengawasan_bongkar_muat_1_percent',
        'pnbp_bongkar_muat_barang_berbahaya',
        'tonase_bongkar',
        'tonase_muat',
        'pnbp_jasa_rambu_kapal'
    ];

    protected $casts = [
        'nomor_spk_pandu' => 'string'
    ];

    public static array $rules = [
        'ais_data_vessel_id' => 'nullable',
        'nomor_spk_pandu' => 'nullable|string|max:255',
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

    public function reportGeofencePandu(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(\App\Models\ReportGeofencePandu::class, 'report_geofence_pandu_id');
    }

    public function inaportnetPergerakanKapal(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(\App\Models\InaportnetPergerakanKapal::class, 'inaportnet_pergerakan_kapal_id');
    }
}
