<?php

namespace App\Filament\Resources\BupKonsesiResource\Pages;

use App\Filament\Resources\BupKonsesiResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditBupKonsesi extends EditRecord
{
    protected static string $resource = BupKonsesiResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
