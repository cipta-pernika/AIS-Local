<?php

namespace App\Filament\Resources\DataloggerResource\Pages;

use App\Filament\Resources\DataloggerResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditDatalogger extends EditRecord
{
    protected static string $resource = DataloggerResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
