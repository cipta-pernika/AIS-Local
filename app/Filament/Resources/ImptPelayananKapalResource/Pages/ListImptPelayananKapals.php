<?php

namespace App\Filament\Resources\ImptPelayananKapalResource\Pages;

use App\Filament\Resources\ImptPelayananKapalResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListImptPelayananKapals extends ListRecords
{
    protected static string $resource = ImptPelayananKapalResource::class;

    protected static ?string $title = 'IMPT Pelayanan Kapal';

    protected function getHeaderActions(): array
    {
        return [
        ];
    }
}
