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
            $image->id,
            $image->name,
            $image->created_at,
            $image->updated_at,
            // Add more fields as necessary
        ];
    }

    public function headings(): array
    {
        return [
            "ID",
            "Name",
            "Created At",
            "Updated At",
            // Add more headings as necessary
        ];
    }
}
