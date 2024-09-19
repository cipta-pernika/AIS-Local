<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Class Sensor
 *
 * @property $id
 * @property $datalogger_id
 * @property $name
 * @property $status
 * @property $interval
 * @property $jarak
 * @property $jumlah_data
 * @property $created_at
 * @property $updated_at
 *
 * @property Datalogger $datalogger
 * @property SensorData[] $sensorDatas
 * @package App
 * @mixin \Illuminate\Database\Eloquent\Builder
 */
class Sensor extends Model
{
    
    protected $perPage = 20;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = ['datalogger_id', 'name', 'status', 'interval', 'jarak', 'jumlah_data'];


    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function datalogger()
    {
        return $this->belongsTo(\App\Models\Datalogger::class, 'datalogger_id', 'id');
    }
    
    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function sensorDatas()
    {
        return $this->hasMany(\App\Models\SensorData::class, 'id', 'sensor_id');
    }
    
}
