<?php

namespace App\Filament\Resources\MapSettingResource\Pages;

use App\Filament\Resources\MapSettingResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditMapSetting extends EditRecord
{
    protected static string $resource = MapSettingResource::class;

    protected function getHeaderActions(): array
    {
        return [
            // Actions\DeleteAction::make(),
        ];
    }
}
