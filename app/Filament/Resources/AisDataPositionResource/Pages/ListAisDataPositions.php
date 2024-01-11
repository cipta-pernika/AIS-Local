<?php

namespace App\Filament\Resources\AisDataPositionResource\Pages;

use App\Filament\Resources\AisDataPositionResource;
use Filament\Actions;
use Filament\Actions\ActionGroup;
use Filament\Resources\Pages\ListRecords;
use pxlrbt\FilamentExcel\Actions\Pages\ExportAction;

class ListAisDataPositions extends ListRecords
{
    protected static string $resource = AisDataPositionResource::class;

    public ?string $tableSortColumn = 'created_at';

    public ?string $tableSortDirection = 'desc';

    protected function getHeaderActions(): array
    {
        return [
            // Actions\CreateAction::make(),
            ActionGroup::make([
                ExportAction::make(),
            ])
        ];
    }
}
