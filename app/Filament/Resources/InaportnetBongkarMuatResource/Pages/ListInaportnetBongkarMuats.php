<?php

namespace App\Filament\Resources\InaportnetBongkarMuatResource\Pages;

use App\Filament\Resources\InaportnetBongkarMuatResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListInaportnetBongkarMuats extends ListRecords
{
    protected static string $resource = InaportnetBongkarMuatResource::class;

    protected static ?string $title = 'INAPORTNET Bongkar Muat';

    protected function getHeaderActions(): array
    {
        return [
            // Actions\CreateAction::make(),
        ];
    }
}
