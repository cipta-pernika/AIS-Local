<?php

namespace App\Filament\Resources\InaportnetBongkarMuatResource\Pages;

use App\Filament\Resources\InaportnetBongkarMuatResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditInaportnetBongkarMuat extends EditRecord
{
    protected static string $resource = InaportnetBongkarMuatResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
