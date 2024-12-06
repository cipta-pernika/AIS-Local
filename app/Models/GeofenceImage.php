<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class GeofenceImage extends Model
{
    public $table = 'geofence_images';

    public $fillable = [
        'image_path',
        'mmsi',
        'geofence_id',
        'vessel_name',
        'timestamp',
        'report_geofence_id'
    ];

    protected $casts = [
        'image_path' => 'string',
        'mmsi' => 'string',
        'vessel_name' => 'string',
        'timestamp' => 'datetime',
        'report_geofence_id' => 'integer'
    ];

    public static array $rules = [
        'image_path' => 'required|string|max:255',
        'mmsi' => 'required|string|max:255',
        'geofence_id' => 'required',
        'vessel_name' => 'nullable|string|max:255',
        'timestamp' => 'required',
        'created_at' => 'nullable',
        'updated_at' => 'nullable',
        'report_geofence_id' => 'nullable'
    ];

    public function geofence(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(\App\Models\Geofence::class, 'geofence_id');
    }

    public function reportGeofence(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(\App\Models\ReportGeofence::class, 'report_geofence_id');
    }   
}
