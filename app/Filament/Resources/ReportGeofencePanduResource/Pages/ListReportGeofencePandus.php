<?php

namespace App\Filament\Resources\ReportGeofencePanduResource\Pages;

use App\Filament\Resources\ReportGeofencePanduResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListReportGeofencePandus extends ListRecords
{
    protected static string $resource = ReportGeofencePanduResource::class;

    protected function getHeaderActions(): array
    {
        return [
            // Actions\CreateAction::make(),
        ];
    }
}
