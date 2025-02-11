<?php

namespace App\Filament\Resources\AisDataPositionResource\Pages;

use App\Filament\Resources\AisDataPositionResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditAisDataPosition extends EditRecord
{
    protected static string $resource = AisDataPositionResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
