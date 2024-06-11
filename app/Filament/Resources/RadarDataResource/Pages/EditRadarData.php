<?php

namespace App\Filament\Resources\RadarDataResource\Pages;

use App\Filament\Resources\RadarDataResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditRadarData extends EditRecord
{
    protected static string $resource = RadarDataResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
