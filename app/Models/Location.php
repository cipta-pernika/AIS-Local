<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Class Location
 *
 * @property $id
 * @property $name
 * @property $location_type_id
 * @property $latitude
 * @property $longitude
 * @property $created_at
 * @property $updated_at
 *
 * @property LocationType $locationType
 * @package App
 * @mixin \Illuminate\Database\Eloquent\Builder
 */
class Location extends Model
{
    
    protected $perPage = 20;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = ['name', 'location_type_id', 'latitude', 'longitude'];


    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function locationType()
    {
        return $this->belongsTo(\App\Models\LocationType::class, 'location_type_id', 'id');
    }
    
}
