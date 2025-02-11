<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Cache;

class Geofence extends Model
{
    use HasFactory, SoftDeletes;

    protected $dates = ['deleted_at'];

    protected static function boot()
    {
        parent::boot();

        // Event fired when a new record is created
        static::created(function ($post) {
            Cache::forget('all_geofences'); // Replace 'posts' with your actual cache key or tag
        });

        // Event fired when a record is updated
        static::updated(function ($post) {
            Cache::forget('all_geofences'); // Replace 'posts' with your actual cache key or tag
        });

        // Event fired when a record is deleted
        static::deleted(function ($post) {
            Cache::forget('all_geofences'); // Replace 'posts' with your actual cache key or tag
        });
    }

    public function pelabuhan(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(\App\Models\Pelabuhan::class, 'pelabuhan_id');
    }

    public function location(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(\App\Models\Location::class, 'location_id');
    }

    public function geofenceType()
    {
        return $this->belongsTo(GeofenceType::class);
    }

    public function geofenceImages()
    {
        return $this->hasMany(GeofenceImage::class);
    }
}
