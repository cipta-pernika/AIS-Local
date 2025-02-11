<?php

namespace App\Filament\Resources\AdsbDataPositionResource\Pages;

use App\Filament\Resources\AdsbDataPositionResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditAdsbDataPosition extends EditRecord
{
    protected static string $resource = AdsbDataPositionResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
