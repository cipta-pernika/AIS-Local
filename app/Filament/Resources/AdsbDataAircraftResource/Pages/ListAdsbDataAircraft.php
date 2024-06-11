<?php

namespace App\Filament\Resources\AdsbDataAircraftResource\Pages;

use App\Filament\Resources\AdsbDataAircraftResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListAdsbDataAircraft extends ListRecords
{
    protected static string $resource = AdsbDataAircraftResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
