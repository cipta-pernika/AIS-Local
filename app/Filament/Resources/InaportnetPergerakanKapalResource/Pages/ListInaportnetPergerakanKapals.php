<?php

namespace App\Filament\Resources\InaportnetPergerakanKapalResource\Pages;

use App\Filament\Resources\InaportnetPergerakanKapalResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListInaportnetPergerakanKapals extends ListRecords
{
    protected static string $resource = InaportnetPergerakanKapalResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
