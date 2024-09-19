<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Class LocationType
 *
 * @property $id
 * @property $name
 * @property $description
 * @property $icon
 * @property $color
 * @property $created_at
 * @property $updated_at
 *
 * @property Location[] $locations
 * @package App
 * @mixin \Illuminate\Database\Eloquent\Builder
 */
class LocationType extends Model
{
    
    protected $perPage = 20;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = ['name', 'description', 'icon', 'color'];


    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function locations()
    {
        return $this->hasMany(\App\Models\Location::class, 'id', 'location_type_id');
    }
    
}
