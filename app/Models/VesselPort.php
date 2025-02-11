<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class VesselPort extends Model
{
    use HasFactory;

    protected $fillable = [
        'vessel_id',
        'port_id',
        'visit_date',
    ];
}
