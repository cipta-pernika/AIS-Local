<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PanduTidakTerjadwal extends Model
{
    public $table = 'pandu_tidak_terjadwals';

    public $fillable = [
        'ais_data_vessel_id',
        'isPassing',
        'geofence_id',
        'nomor_spk_pandu',
        'ais_data_position_id',
        'report_geofence_id'
    ];

    protected $casts = [
        'isPassing' => 'boolean',
        'nomor_spk_pandu' => 'string'
    ];

    public static array $rules = [
        'ais_data_vessel_id' => 'nullable',
        'isPassing' => 'required|boolean',
        'geofence_id' => 'nullable',
        'nomor_spk_pandu' => 'nullable|string|max:255',
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
}
