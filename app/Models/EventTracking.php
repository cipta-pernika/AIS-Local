<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class EventTracking extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'asset_id', 'event_id', 'ais_data_position_id', 'mmsi', 'ship_name'
    ];

    public function asset()
    {
        return $this->belongsTo(Asset::class);
    }

    public function event()
    {
        return $this->belongsTo(Event::class);
    }

    public function aisDataPosition()
    {
        return $this->belongsTo(AisDataPosition::class);
    }
}
