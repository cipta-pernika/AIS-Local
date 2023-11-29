<?php

namespace App\Filament\Resources\EventTrackingResource\Pages;

use App\Filament\Resources\EventTrackingResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditEventTracking extends EditRecord
{
    protected static string $resource = EventTrackingResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
