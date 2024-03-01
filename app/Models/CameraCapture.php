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

    
}
