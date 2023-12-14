<?php

namespace App\Filament\Resources\MapSettingResource\Pages;

use App\Filament\Resources\MapSettingResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListMapSettings extends ListRecords
{
    protected static string $resource = MapSettingResource::class;

    protected function getHeaderActions(): array
    {
        return [
            // Actions\CreateAction::make(),
        ];
    }
}
