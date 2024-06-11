<?php

namespace App\Filament\Resources\AdsbDataPositionResource\Pages;

use App\Filament\Resources\AdsbDataPositionResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListAdsbDataPositions extends ListRecords
{
    protected static string $resource = AdsbDataPositionResource::class;

    protected function getHeaderActions(): array
    {
        return [
            // Actions\CreateAction::make(),
        ];
    }
}
