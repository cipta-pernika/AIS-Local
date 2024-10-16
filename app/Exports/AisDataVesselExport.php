<?php

namespace App\Exports;

use App\Models\AisDataPosition;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;

class AisDataVesselExport implements FromCollection, WithHeadings, WithMapping
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

    public function map($vessel): array
    {
        return [
            $vessel->vessel_name,
            $vessel->vessel_type,
            $vessel->mmsi,
            $vessel->imo,
            $vessel->callsign,
            $vessel->nama_negara,
            $vessel->tipe_kapal,
            $vessel->nama_perusahaan,
            $vessel->gt_kapal,
            $vessel->jenis_layanan,
            $vessel->dwt,
            $vessel->nakhoda,
            $vessel->jenis_trayek,
            $vessel->pelabuhan_asal,
            $vessel->pelabuhan_tujuan,
            $vessel->tgl_tiba,
            $vessel->tgl_brangkat,
            $vessel->distance,
            // $vessel->is_inside_geofence,
        ];
    }

    public function headings(): array
    {
        return [
            "Vessel Name",
            "Vessel Type",
            "MMSI",
            "IMO",
            "Callsign",
            "Nama Negara",
            "Tipe Kapal",
            "Nama Perusahaan",
            "GT Kapal",
            "Jenis Layanan",
            "Dwt",
            "Nakhoda",
            "Jenis Trayek",
            "Pelabuhan Asal",
            "Pelabuhan Tujuan",
            "Tgl Tiba",
            "Tgl Brangkat",
            "Distance",
            // "Is Inside Geofence",
        ];
    }
}
