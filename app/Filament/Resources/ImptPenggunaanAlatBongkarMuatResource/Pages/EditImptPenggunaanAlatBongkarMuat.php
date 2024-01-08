<?php

namespace App\Filament\Resources\ImptPenggunaanAlatBongkarMuatResource\Pages;

use App\Filament\Resources\ImptPenggunaanAlatBongkarMuatResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditImptPenggunaanAlatBongkarMuat extends EditRecord
{
    protected static string $resource = ImptPenggunaanAlatBongkarMuatResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
