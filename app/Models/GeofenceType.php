<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class GeofenceType extends Model
{
    public $table = 'geofence_types';

    public $fillable = [
        'name',
        'base_price',
        'uom',
        'vessel_type',
        'speed'
    ];

    protected $casts = [
        'name' => 'string',
        'base_price' => 'decimal:2',
        'uom' => 'string',
    ];

    public static array $rules = [
        'name' => 'required|string|max:255',
        'base_price' => 'required|numeric',
        'uom' => 'required|string|max:255',
        'created_at' => 'nullable',
        'updated_at' => 'nullable'
    ];

    public function geofences()
    {
        return $this->hasMany(Geofence::class);
    }
}
