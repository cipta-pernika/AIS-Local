<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Location extends Model
{
    public $table = 'locations';

    public $fillable = [
        'name',
        'location_type_id',
        'latitude',
        'longitude'
    ];

    protected $casts = [
        'name' => 'string',
        'latitude' => 'decimal:7',
        'longitude' => 'decimal:7'
    ];

    public static array $rules = [
        'name' => 'required|string|max:255',
        'location_type_id' => 'required',
        'latitude' => 'required|numeric',
        'longitude' => 'required|numeric',
        'created_at' => 'nullable',
        'updated_at' => 'nullable'
    ];

    public function locationType(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(\App\Models\LocationType::class, 'location_type_id');
    }

    // public function geofence()
    // {
    //     return $this->belongsTo(Geofence::class, 'id', 'id');
    // }

    public function geofences(): HasMany
    {
        return $this->hasMany(Geofence::class, 'location_id');
    }
}
