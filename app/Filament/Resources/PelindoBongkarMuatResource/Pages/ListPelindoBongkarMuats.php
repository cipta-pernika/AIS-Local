<?php

namespace App\Filament\Resources\PelindoBongkarMuatResource\Pages;

use App\Filament\Resources\PelindoBongkarMuatResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListPelindoBongkarMuats extends ListRecords
{
    protected static string $resource = PelindoBongkarMuatResource::class;

    protected function getHeaderActions(): array
    {
        return [
            // Actions\CreateAction::make(),
        ];
    }
}
