<?php

namespace App\Filament\Resources\DataTransferLogResource\Pages;

use App\Filament\Resources\DataTransferLogResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditDataTransferLog extends EditRecord
{
    protected static string $resource = DataTransferLogResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
