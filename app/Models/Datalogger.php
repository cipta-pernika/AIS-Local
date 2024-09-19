<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Class Datalogger
 *
 * @property $id
 * @property $name
 * @property $serial_number
 * @property $latitude
 * @property $longitude
 * @property $status
 * @property $installation_date
 * @property $last_online
 * @property $coverage
 * @property $pelabuhan_id
 * @property $created_at
 * @property $updated_at
 *
 * @property Sensor[] $sensors
 * @package App
 * @mixin \Illuminate\Database\Eloquent\Builder
 */
class Datalogger extends Model
{
    
    protected $perPage = 20;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = ['name', 'serial_number', 'latitude', 'longitude', 'status', 'installation_date', 'last_online', 'coverage', 'pelabuhan_id'];


    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function sensors()
    {
        return $this->hasMany(\App\Models\Sensor::class, 'id', 'datalogger_id');
    }
    
}
