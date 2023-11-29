<?php

namespace App\Filament\Resources\AisDataPositionResource\Pages;

use App\Filament\Resources\AisDataPositionResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListAisDataPositions extends ListRecords
{
    protected static string $resource = AisDataPositionResource::class;

    protected function getHeaderActions(): array
    {
        return [
            // Actions\CreateAction::make(),
        ];
    }
}
