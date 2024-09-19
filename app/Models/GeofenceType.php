<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Class GeofenceType
 *
 * @property $id
 * @property $name
 * @property $base_price
 * @property $uom
 * @property $vessel_type
 * @property $speed
 * @property $created_at
 * @property $updated_at
 *
 * @package App
 * @mixin \Illuminate\Database\Eloquent\Builder
 */
class GeofenceType extends Model
{
    
    protected $perPage = 20;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = ['name', 'base_price', 'uom', 'vessel_type', 'speed'];


}
