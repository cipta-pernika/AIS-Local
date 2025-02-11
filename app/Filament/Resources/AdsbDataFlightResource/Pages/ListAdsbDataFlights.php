<?php

namespace App\Filament\Resources\AdsbDataFlightResource\Pages;

use App\Filament\Resources\AdsbDataFlightResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListAdsbDataFlights extends ListRecords
{
    protected static string $resource = AdsbDataFlightResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
