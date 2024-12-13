<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Cache;

class EventTracking extends Model
{
    protected static function boot()
    {
        parent::boot();

        static::created(function ($post) {
            Cache::forget('event_trackings_cache');
        });

        static::updated(function ($post) {
            Cache::forget('event_trackings_cache');
        });

        static::deleted(function ($post) {
            Cache::forget('event_trackings_cache');
        });
    }

    public $table = 'event_trackings';

    public $fillable = [
        'asset_id',
        'event_id',
        'ais_data_position_id',
        'notes',
        'mmsi',
        'ship_name',
        'geofence_id',
        'target_id'
    ];

    protected $casts = [
        'notes' => 'string',
        'mmsi' => 'string',
        'ship_name' => 'string'
    ];

    public static array $rules = [
        'asset_id' => 'nullable',
        'event_id' => 'required',
        'ais_data_position_id' => 'nullable',
        'notes' => 'nullable|string|max:255',
        'mmsi' => 'nullable|string|max:255',
        'ship_name' => 'nullable|string|max:255',
        'deleted_at' => 'nullable',
        'created_at' => 'nullable',
        'updated_at' => 'nullable'
    ];

    public function aisDataPosition(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(\App\Models\AisDataPosition::class, 'ais_data_position_id','id');
    }

    public function asset(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(\App\Models\Asset::class, 'asset_id');
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
