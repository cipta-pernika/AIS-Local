<?php

namespace App\Filament\Resources\IdentificationResource\Pages;

use App\Filament\Resources\IdentificationResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditIdentification extends EditRecord
{
    protected static string $resource = IdentificationResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
