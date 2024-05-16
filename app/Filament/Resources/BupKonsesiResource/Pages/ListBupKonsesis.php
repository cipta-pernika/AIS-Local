<?php

namespace App\Filament\Resources\BupKonsesiResource\Pages;

use App\Filament\Resources\BupKonsesiResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListBupKonsesis extends ListRecords
{
    protected static string $resource = BupKonsesiResource::class;

    protected static ?string $title = 'BUP Konsesi';

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
