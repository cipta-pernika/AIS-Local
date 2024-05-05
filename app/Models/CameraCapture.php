<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CameraCapture extends Model
{
    public $table = 'camera_captures';

    public $fillable = [
        'pelabuhan_id',
        'geofence_id',
        'image'
    ];

    protected $casts = [
        'image' => 'string'
    ];

    public static array $rules = [
        'pelabuhan_id' => 'nullable|integer',
        'geofence_id' => 'nullable|integer',
        'image' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
        'created_at' => 'nullable',
        'updated_at' => 'nullable'
    ];

    public function pelabuhan(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(\App\Models\Pelabuhan::class, 'pelabuhan_id');
    }

    public function geofence(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(\App\Models\Geofence::class, 'geofence_id');
    }
}
