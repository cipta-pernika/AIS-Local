<?php

namespace App\Filament\Resources\LocationTypeResource\Pages;

use App\Filament\Resources\LocationTypeResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditLocationType extends EditRecord
{
    protected static string $resource = LocationTypeResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
