<?php

namespace App\Filament\Resources\DataloggerResource\Pages;

use App\Filament\Resources\DataloggerResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListDataloggers extends ListRecords
{
    protected static string $resource = DataloggerResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
