<?php

namespace App\Filament\Resources\PelindoBongkarMuatResource\Pages;

use App\Filament\Resources\PelindoBongkarMuatResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditPelindoBongkarMuat extends EditRecord
{
    protected static string $resource = PelindoBongkarMuatResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
