<?php

namespace App\Repositories;

use App\Models\BupKonsesi;
use App\Repositories\BaseRepository;

class BupKonsesiRepository extends BaseRepository
{
    protected $fieldSearchable = [
        'bup',
        'bruto',
        'besaran_konsesi',
        'pendapatan_konsesi',
        'month'
    ];

    public function getFieldsSearchable(): array
    {
        return $this->fieldSearchable;
    }

    public function model(): string
    {
        return BupKonsesi::class;
    }
}
