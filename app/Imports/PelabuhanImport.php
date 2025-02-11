<?php

namespace App\Imports;

use App\Models\Pelabuhan;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\OnEachRow;
use Maatwebsite\Excel\Concerns\WithStartRow;
use Maatwebsite\Excel\Row;

class PelabuhanImport implements OnEachRow, WithStartRow
{
    /**
     * @return int
     */
    public function startRow(): int
    {
        return 2;
    }

    /**
     * @param array $row
     *
     * @return \Illuminate\Database\Eloquent\Model|null
     */
    public function onRow(Row $row)
    {
        if ($row[0] && $row[1]) {
            $pelabuhan = Pelabuhan::updateOrCreate([
                'name' => $row[0],
            ]);
        }
    }
}
