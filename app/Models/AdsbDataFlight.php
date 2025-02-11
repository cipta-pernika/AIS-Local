<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AdsbDataFlight extends Model
{
    use HasFactory;

    protected $table = 'adsb_data_flights';

    protected $fillable = [
        'aircraft_id',
        'flight_number',
        'date',
        'from',
        'to',
        'flight_time',
        'std',
        'atd',
        'sta',
    ];

    public function aircraft()
    {
        return $this->belongsTo(AdsbDataAircraft::class, 'aircraft_id');
    }
}
