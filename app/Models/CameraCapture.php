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
        'pelabuhan_id' => 'nullable',
        'geofence_id' => 'nullable',
        'image' => 'required|string|max:255',
        'created_at' => 'nullable',
        'updated_at' => 'nullable'
    ];

    
}
