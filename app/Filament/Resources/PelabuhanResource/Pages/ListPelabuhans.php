<?php

namespace App\Filament\Resources\PelabuhanResource\Pages;

use App\Filament\Resources\PelabuhanResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;
use Konnco\FilamentImport\Actions\ImportField;
use Konnco\FilamentImport\Actions\ImportAction;

class ListPelabuhans extends ListRecords
{
    protected static string $resource = PelabuhanResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
            // ImportAction::make()
            //     ->fields([
            //         ImportField::make('name'),
            //         ImportField::make('latitude'),
            //         ImportField::make('longitude'),
            //         ImportField::make('penanggung_jawab'),
            //         ImportField::make('no_izin_pengoperasian'),
            //         ImportField::make('tgl_izin_pengoperasian'),
            //         ImportField::make('penerbit_izin_pengoperasian'),
            //         ImportField::make('no_perjanjian_sewa_perairan'),
            //         ImportField::make('tgl_sewa_perairan'),
            //     ]),
            \EightyNine\ExcelImport\ExcelImportAction::make()
                ->color("primary"),
        ];
    }
}
