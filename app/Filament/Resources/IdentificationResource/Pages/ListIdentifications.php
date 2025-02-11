<?php

namespace App\Filament\Resources\IdentificationResource\Pages;

use App\Filament\Resources\IdentificationResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListIdentifications extends ListRecords
{
    protected static string $resource = IdentificationResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
