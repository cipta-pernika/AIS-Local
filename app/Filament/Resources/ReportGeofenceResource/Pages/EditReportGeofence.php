<?php

namespace App\Filament\Resources\ReportGeofenceResource\Pages;

use App\Filament\Resources\ReportGeofenceResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditReportGeofence extends EditRecord
{
    protected static string $resource = ReportGeofenceResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
