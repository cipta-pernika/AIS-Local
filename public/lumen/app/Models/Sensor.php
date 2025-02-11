<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Sensor extends Model
{
    use HasFactory;

    protected $fillable = [
        'datalogger_id',
        'name',
        'status',
        'interval',
        'jarak',
        'jumlah_data',
    ];

    public function sensorData()
    {
        return $this->hasMany(SensorData::class);
    }

    // Relationship with Datalogger
    public function datalogger()
    {
        return $this->belongsTo(Datalogger::class);
    }
}
