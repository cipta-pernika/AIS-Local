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
        'flag',
        'imo',
        'length',
        'width',
    ];

    // Define relationships
    public function positions()
    {
        return $this->hasMany(AisDataPosition::class, 'vessel_id');
    }
}
