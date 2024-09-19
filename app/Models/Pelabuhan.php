<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Class Pelabuhan
 *
 * @property $id
 * @property $name
 * @property $un_locode
 * @property $latitude
 * @property $longitude
 * @property $radius
 * @property $address
 * @property $created_at
 * @property $updated_at
 *
 * @package App
 * @mixin \Illuminate\Database\Eloquent\Builder
 */
class Pelabuhan extends Model
{
    
    protected $perPage = 20;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = ['name', 'un_locode', 'latitude', 'longitude', 'radius', 'address'];


}
