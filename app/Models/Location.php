<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Cache;

class Location extends Model
{
    use HasFactory;

    protected static function boot()
    {
        parent::boot();

        static::created(function ($post) {
            Cache::forget('locations_cache');
        });

        static::updated(function ($post) {
            Cache::forget('locations_cache');
        });

        static::deleted(function ($post) {
            Cache::forget('locations_cache');
        });
    }

    protected $fillable = [
        'name',
        'location_type_id',
        'latitude',
        'longitude'
    ];

    public function locationType()
    {
        return $this->belongsTo(LocationType::class);
    }
}
