<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Datalogger extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'serial_number',
        'latitude',
        'longitude',
        'status',
        'installation_date',
        'last_online',
    ];

    public function sensors()
    {
        return $this->hasMany(Sensor::class);
    }
}
