<?php

namespace App\Filament\Resources\ImptBongkarMuatResource\Pages;

use App\Filament\Resources\ImptBongkarMuatResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditImptBongkarMuat extends EditRecord
{
    protected static string $resource = ImptBongkarMuatResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
