<?php

namespace App\Filament\Resources\PbkmKegiatanPemanduanResource\Pages;

use App\Filament\Resources\PbkmKegiatanPemanduanResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListPbkmKegiatanPemanduans extends ListRecords
{
    protected static string $resource = PbkmKegiatanPemanduanResource::class;

    protected function getHeaderActions(): array
    {
        return [
            // Actions\CreateAction::make(),
        ];
    }
}
