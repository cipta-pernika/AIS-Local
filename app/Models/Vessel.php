<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Vessel extends Model
{
    use HasFactory;

    protected $fillable = [
        'vessel_name',
        'vessel_type',
        'flag',
        'imo',
        'mmsi',
        'length',
        'width',
    ];
}
