<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ReportGeofencePandu extends Model
{
    public $table = 'report_geofence_pandus';

    public $fillable = [
        'ais_data_position_id',
        'geofence_id',
        'mmsi',
        'nama_kapal',
        'nomor_spk_pandu',
        'in',
        'out',
        'total_time'
    ];

    protected $casts = [
        'mmsi' => 'string',
        'nama_kapal' => 'string',
        'nomor_spk_pandu' => 'string',
        'in' => 'datetime',
        'out' => 'datetime',
        'total_time' => 'string'
    ];

    public static array $rules = [
        'ais_data_position_id' => 'nullable',
        'geofence_id' => 'nullable',
        'mmsi' => 'nullable|string|max:255',
        'nama_kapal' => 'nullable|string|max:255',
        'nomor_spk_pandu' => 'nullable|string|max:255',
        'in' => 'nullable',
        'out' => 'nullable',
        'total_time' => 'nullable|string|max:255',
        'deleted_at' => 'nullable',
        'created_at' => 'nullable',
        'updated_at' => 'nullable'
    ];

    public function aisDataPosition(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(\App\Models\AisDataPosition::class, 'ais_data_position_id');
    }

    public function geofence(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(\App\Models\Geofence::class, 'geofence_id');
    }
}
