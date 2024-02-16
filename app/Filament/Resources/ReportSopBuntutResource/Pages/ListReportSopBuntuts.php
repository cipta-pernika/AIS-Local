<?php

namespace App\Filament\Resources\ReportSopBuntutResource\Pages;

use App\Filament\Resources\ReportSopBuntutResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListReportSopBuntuts extends ListRecords
{
    protected static string $resource = ReportSopBuntutResource::class;

    protected function getHeaderActions(): array
    {
        return [
            // Actions\CreateAction::make(),
        ];
    }
}
