<?php

namespace App\Filament\Resources\GeofenceTypeResource\Pages;

use App\Filament\Resources\GeofenceTypeResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListGeofenceTypes extends ListRecords
{
    protected static string $resource = GeofenceTypeResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
