<?php

namespace App\Filament\Resources\ReportGeofencePanduResource\Pages;

use App\Filament\Resources\ReportGeofencePanduResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditReportGeofencePandu extends EditRecord
{
    protected static string $resource = ReportGeofencePanduResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
