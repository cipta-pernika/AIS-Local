<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ReportSopBuntut extends Model
{
    use HasFactory;

    protected $table = 'report_sopbuntut';

    // Define any relationships if needed
    public function geofence()
    {
        return $this->belongsTo(Geofence::class); // Assuming you have a Geofence model
    }

    public function aisDataVessel()
    {
        return $this->belongsTo(AisDataVessel::class, 'id', 'vessel_id'); // Assuming you have an AisDataVessel model
    }

    protected $casts = [
        'created_at' => 'datetime',
        'dimension_to_bow' => 'float',
        'draught' => 'integer',
        'dimension_to_stern' => 'float',
        'dimension_to_port' => 'float',
        'dimension_to_starboard' => 'float',
        'in' => 'datetime', // Assuming 'in' column is datetime
        'out' => 'datetime', // Assuming 'out' column is datetime
        'total_time' => 'integer', // Assuming 'total_time' column is integer
        // Add more casts as needed
    ];
    
}
