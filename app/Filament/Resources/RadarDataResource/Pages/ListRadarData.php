<?php

namespace App\Filament\Resources\RadarDataResource\Pages;

use App\Filament\Resources\RadarDataResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListRadarData extends ListRecords
{
    protected static string $resource = RadarDataResource::class;

    protected function getHeaderActions(): array
    {
        return [
            // Actions\CreateAction::make(),
        ];
    }
}
