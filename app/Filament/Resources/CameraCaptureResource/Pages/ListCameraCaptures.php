<?php

namespace App\Filament\Resources\CameraCaptureResource\Pages;

use App\Filament\Resources\CameraCaptureResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListCameraCaptures extends ListRecords
{
    protected static string $resource = CameraCaptureResource::class;

    protected function getHeaderActions(): array
    {
        return [
            // Actions\CreateAction::make(),
        ];
    }
}
