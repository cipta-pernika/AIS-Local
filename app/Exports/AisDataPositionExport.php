<?php

namespace App\Exports;

use App\Models\AisDataPosition;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;

class AisDataPositionExport implements FromCollection, WithHeadings, WithMapping
{
    protected $data;

    public function __construct($data)
    {
        $this->data = $data;
    }
    /**
     * @return \Illuminate\Support\Collection
     */
    public function collection()
    {
        return $this->data;
    }

    public function map($tracking): array
    {
        return [
            $tracking->sensor_data_id,
            $tracking->vessel_id,
            $tracking->port_id,
            $tracking->latitude,
            $tracking->longitude,
            $tracking->speed,
            $tracking->course,
            $tracking->heading,
            $tracking->navigation_status,
            $tracking->timestamp,
            $tracking->turning_rate,
            $tracking->turning_direction,
            $tracking->distance,
            // $tracking->is_inside_geofence,
        ];
    }

    public function headings(): array
    {
        return [
            "Sensor Data ID",
            "Vessel ID",
            "Port ID",
            "Latitude",
            "Longitude",
            "Speed",
            "Course",
            "Heading",
            "Navigation Status",
            "Timestamp",
            "Turning Rate",
            "Turning Direction",
            "Distance",
            // "Is Inside Geofence",
        ];
    }
}
