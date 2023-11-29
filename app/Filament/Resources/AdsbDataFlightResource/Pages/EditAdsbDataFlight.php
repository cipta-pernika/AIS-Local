<?php

namespace App\Filament\Resources\AdsbDataFlightResource\Pages;

use App\Filament\Resources\AdsbDataFlightResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditAdsbDataFlight extends EditRecord
{
    protected static string $resource = AdsbDataFlightResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
