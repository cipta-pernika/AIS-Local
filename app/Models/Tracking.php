<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Tracking extends Model
{
    public $table = 'trackings';

    public $fillable = [
        'asset_id',
        'latitude',
        'longitude',
        'altitude',
        'velocity',
        'heading',
        'event_id',
        'bat_lvl',
        'signal',
        'timestamp',
        'data_flow_id',
        'engine_rpm_id',
        'bat_hours',
        'satellite',
        'location',
        'orbcomm_id'
    ];

    protected $casts = [
        'latitude' => 'decimal:6',
        'longitude' => 'decimal:6',
        'altitude' => 'decimal:2',
        'velocity' => 'decimal:2',
        'heading' => 'decimal:2',
        'bat_lvl' => 'decimal:2',
        'signal' => 'string',
        'timestamp' => 'datetime',
        'data_flow_id' => 'string',
        'bat_hours' => 'decimal:2',
        'satellite' => 'string',
        'location' => 'string',
        'orbcomm_id' => 'string'
    ];

    public static array $rules = [
        'asset_id' => 'nullable',
        'latitude' => 'nullable|numeric',
        'longitude' => 'nullable|numeric',
        'altitude' => 'nullable|numeric',
        'velocity' => 'nullable|numeric',
        'heading' => 'nullable|numeric',
        'event_id' => 'nullable',
        'bat_lvl' => 'nullable|numeric',
        'signal' => 'nullable|string|max:255',
        'timestamp' => 'nullable',
        'data_flow_id' => 'nullable|string|max:255',
        'engine_rpm_id' => 'nullable',
        'bat_hours' => 'nullable|numeric',
        'satellite' => 'nullable|string|max:255',
        'location' => 'nullable|string|max:255',
        'orbcomm_id' => 'nullable|string|max:255',
        'created_at' => 'nullable',
        'updated_at' => 'nullable'
    ];

    
}
