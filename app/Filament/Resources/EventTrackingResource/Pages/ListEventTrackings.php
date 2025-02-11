<?php

namespace App\Filament\Resources\EventTrackingResource\Pages;

use AlperenErsoy\FilamentExport\Actions\FilamentExportHeaderAction;
use App\Filament\Resources\EventTrackingResource;
use Filament\Actions;
use Filament\Actions\ActionGroup;
use Filament\Resources\Pages\ListRecords;
use pxlrbt\FilamentExcel\Actions\Pages\ExportAction;

class ListEventTrackings extends ListRecords
{
    protected static string $resource = EventTrackingResource::class;

    protected function getHeaderActions(): array
    {
        return [
            // Actions\CreateAction::make(),
            ActionGroup::make([
                ExportAction::make(),
                // FilamentExportHeaderAction::make('export')
            ])
        ];
    }
}
