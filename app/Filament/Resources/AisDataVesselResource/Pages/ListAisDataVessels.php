<?php

namespace App\Filament\Resources\AisDataVesselResource\Pages;

use App\Filament\Resources\AisDataVesselResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListAisDataVessels extends ListRecords
{
    protected static string $resource = AisDataVesselResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
