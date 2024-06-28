<?php

namespace App\Filament\Resources\ImptPelayananKapalResource\Pages;

use App\Filament\Resources\ImptPelayananKapalResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditImptPelayananKapal extends EditRecord
{
    protected static string $resource = ImptPelayananKapalResource::class;

    protected function getHeaderActions(): array
    {
        return [
            
        ];
    }
}
