<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AdsbDataAircraft extends Model
{
    use HasFactory;

    protected $table = 'adsb_data_aircrafts';

    protected $fillable = [
        'aircraft_name',
        'aircraft_type',
        'acid',
        'registration',
        'country',
        'callsign'
    ];
}
