<?php

namespace App\Exports;

use App\Models\GeofenceImage;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Carbon\Carbon;

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
        $outTime = $image->reportGeofence->out;
        if ($image->reportGeofence->total_time < 30) {
            $outTime = Carbon::parse($image->reportGeofence->in)->addMinutes(30);
        }

        return [
            'https://bebmss.cakrawala.id/storage' . $image->image_path,
            $image->mmsi,
            $image->vessel_name,
            $image->reportGeofence->in,
            $outTime,
            $image->reportGeofence->total_time < 30 ? $image->reportGeofence->total_time + 30 : $image->reportGeofence->total_time,
            // Add more fields as necessary
        ];
    }

    public function headings(): array
    {
        return [
            "Foto",
            "MMSI",
            "Nama Kapal",
            "Waktu Masuk",
            "Waktu Keluar",
            "Total Waktu",
            // Add more headings as necessary
        ];
    }
}
