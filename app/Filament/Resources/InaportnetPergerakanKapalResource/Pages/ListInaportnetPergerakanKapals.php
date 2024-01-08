<?php

namespace App\Filament\Resources\InaportnetPergerakanKapalResource\Pages;

use App\Filament\Resources\InaportnetPergerakanKapalResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListInaportnetPergerakanKapals extends ListRecords
{
    protected static string $resource = InaportnetPergerakanKapalResource::class;

    protected static ?string $title = 'INAPORTNET Pergerakan Kapal';

    protected function getHeaderActions(): array
    {
        return [
        ];
    }
}
