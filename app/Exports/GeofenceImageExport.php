<?php

namespace App\Exports;

use App\Models\GeofenceImage;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;

class GeofenceImageExport implements FromCollection, WithHeadings, WithMapping
{
    protected $data;

    public function __construct($data)
    {
        $this->data = $data;
    }

    public function collection()
    {
        return $this->data;
    }

    public function map($image): array
    {
        return [
            'https://bebmss.cakrawala.id/storage/' . $image->image_path,
            $image->mmsi,
            $image->geofence_id,
            $image->vessel_name,
            $image->timestamp,
            $image->report_geofence_id,
            // Add more fields as necessary
        ];
    }

    public function headings(): array
    {
        return [
            "Image Path",
            "MMSI",
            "Geofence ID",
            "Vessel Name",
            "Timestamp",
            "Report Geofence ID",
            // Add more headings as necessary
        ];
    }
}
