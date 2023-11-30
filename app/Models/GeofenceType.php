<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class GeofenceType extends Model
{
    use HasFactory;

    protected $table = 'geofence_types';

    protected $fillable = [
        'name',
        'base_price',
        'uom',
        'vessel_type'
    ];

    protected $casts = [
        'vessel_type' => 'array',
    ];
}
