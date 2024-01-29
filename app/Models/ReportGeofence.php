<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ReportGeofence extends Model
{
    public $table = 'report_geofences';

    public $fillable = [
        'event_id',
        'ais_data_position_id',
        'geofence_id',
        'in',
        'out',
        'total_time',
        'mmsi',
        'target_id'
    ];

    protected $casts = [
        'in' => 'datetime',
        'out' => 'datetime',
        'total_time' => 'string'
    ];

    public static array $rules = [
        'event_id' => 'required',
        'ais_data_position_id' => 'nullable',
        'geofence_id' => 'nullable',
        'in' => 'required',
        'out' => 'required',
        'total_time' => 'nullable|string|max:255',
        'deleted_at' => 'nullable',
        'created_at' => 'nullable',
        'updated_at' => 'nullable'
    ];

    public function aisDataPosition(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(\App\Models\AisDataPosition::class, 'ais_data_position_id');
    }

    public function event(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(\App\Models\Event::class, 'event_id');
    }

    public function geofence(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(\App\Models\Geofence::class, 'geofence_id');
    }
}
