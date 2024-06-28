<?php

namespace App\Filament\Resources\ImptPenggunaanAlatResource\Pages;

use App\Filament\Resources\ImptPenggunaanAlatResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListImptPenggunaanAlats extends ListRecords
{
    protected static string $resource = ImptPenggunaanAlatResource::class;

    protected function getHeaderActions(): array
    {
        return [
            // Actions\CreateAction::make(),
        ];
    }
}
