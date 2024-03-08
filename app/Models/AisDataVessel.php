<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Laravel\Scout\Searchable;

class AisDataVessel extends Model
{
    use HasFactory;

    // Searchable

    protected $fillable = [
        'vessel_name',
        'vessel_type',
        'mmsi',
        'imo',
        'callsign',
        'draught',
        'reported_destination',
        'reported_eta',
        'dimension_to_bow',
        'dimension_to_stern',
        'dimension_to_port',
        'dimension_to_starboard',
        'type_number',
        'no_pkk',
        'jenis_layanan',
        'nama_negara',
        'tipe_kapal',
        'nama_perusahaan',
        'tgl_tiba',
        'tgl_brangkat',
        'bendera',
        'gt_kapal',
        'dwt',
        'nakhoda',
        'jenis_trayek',
        'pelabuhan_asal',
        'pelabuhan_tujuan',
        'lokasi_lambat_labuh',
        'nomor_spog',
        'jenis_muatan',
        'no_pandu',
        'nama_pandu',
        'nama_kapal_eks',
        'nama_kapal_pemilik',
        ''
    ];

    public function toSearchableArray()
    {
        return [
            'mmsi' => $this->mmsi,
            'vessel_name' => $this->vessel_name,
            'imo' => $this->imo,
        ];
    }

    // Define relationships
    public function positions()
    {
        return $this->hasMany(AisDataPosition::class, 'vessel_id');
    }

    public function reportGeofences()
    {
        return $this->hasMany(ReportGeofence::class, 'mmsi', 'mmsi');
    }
}
