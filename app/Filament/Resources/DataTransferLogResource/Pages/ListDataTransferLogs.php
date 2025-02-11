<?php

namespace App\Filament\Resources\DataTransferLogResource\Pages;

use App\Filament\Resources\DataTransferLogResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListDataTransferLogs extends ListRecords
{
    protected static string $resource = DataTransferLogResource::class;

    protected function getHeaderActions(): array
    {
        return [
            // Actions\CreateAction::make(),
        ];
    }
}
