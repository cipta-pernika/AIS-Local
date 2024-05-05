<?php

namespace App\Filament\Resources\PbkmKegiatanPemanduanResource\Pages;

use App\Filament\Resources\PbkmKegiatanPemanduanResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditPbkmKegiatanPemanduan extends EditRecord
{
    protected static string $resource = PbkmKegiatanPemanduanResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
