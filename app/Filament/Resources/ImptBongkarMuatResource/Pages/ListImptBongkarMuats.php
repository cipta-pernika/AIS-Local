<?php

namespace App\Filament\Resources\ImptBongkarMuatResource\Pages;

use App\Filament\Resources\ImptBongkarMuatResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListImptBongkarMuats extends ListRecords
{
    protected static string $resource = ImptBongkarMuatResource::class;

    protected function getHeaderActions(): array
    {
        return [
            // Actions\CreateAction::make(),
        ];
    }
}
