<?php

namespace App\Filament\Resources\AisDataVesselResource\Pages;

use App\Filament\Resources\AisDataVesselResource;
use Filament\Actions;
use Filament\Actions\ActionGroup;
use Konnco\FilamentImport\Actions\ImportAction;
use pxlrbt\FilamentExcel\Actions\Tables\ExportAction;
use Filament\Resources\Pages\ListRecords;
use Konnco\FilamentImport\Actions\ImportField;

class ListAisDataVessels extends ListRecords
{
    protected static string $resource = AisDataVesselResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
            ActionGroup::make([
                ExportAction::make(),
            ]),
            ImportAction::make()
                ->fields([
                    ImportField::make('vessel_name')
                        ->label('Vessel Name'),
                    ImportField::make('vessel_type')
                        ->label('Vessel Type'),
                ])
        ];
    }

    public static function getGlobalSearchResultDetails(Model $record): array
    {
        return [
            'MMSI' => $record->mmsi,
            'Callsign' => $record->callsign,
        ];
    }
}
