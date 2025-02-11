<?php

namespace App\Filament\Resources\ReportGeofenceBongkarMuatResource\Pages;

use App\Filament\Resources\ReportGeofenceBongkarMuatResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListReportGeofenceBongkarMuats extends ListRecords
{
    protected static string $resource = ReportGeofenceBongkarMuatResource::class;

    protected function getHeaderActions(): array
    {
        return [
            // Actions\CreateAction::make(),
        ];
    }
}
