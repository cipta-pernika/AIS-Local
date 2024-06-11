<?php

namespace App\Filament\Resources\ReportGeofenceBongkarMuatResource\Pages;

use App\Filament\Resources\ReportGeofenceBongkarMuatResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditReportGeofenceBongkarMuat extends EditRecord
{
    protected static string $resource = ReportGeofenceBongkarMuatResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
