<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AisDataVessel extends Model
{
    use HasFactory;

    protected $fillable = [
        'vessel_name',
        'vessel_type',
        'mmsi',
        'imo',
        'callsign',
        'draught',
        'reported_destination',
        'reported_eta',
        'dimension_to_bow',
        'dimension_to_stern',
        'dimension_to_port',
        'dimension_to_starboard',
        'type_number',
    ];

    // Define relationships
    public function positions()
    {
        return $this->hasMany(AisDataPosition::class, 'vessel_id');
    }
}
