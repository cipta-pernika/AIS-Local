<?php

namespace App\Filament\Pages;

use App\Models\AisDataPosition;
use App\Models\AisDataVessel;
use Filament\Pages\Page;
use Filament\Infolists\Components\TextEntry;
use Filament\Infolists\Infolist;

class CekPosisi extends Page
{
    protected static ?string $navigationIcon = 'heroicon-o-document-text';

    protected static string $view = 'filament.pages.cek-posisi';

    public static function shouldRegisterNavigation(): bool
    {
        return false;
    }

    public function getHeading(): string
    {
        return false;
    }

    public function mount(): void
    {
        $ais_vessel = AisDataVessel::where('mmsi', request('mmsi'))->first();
        if ($ais_vessel) {
            $ais_position = AisDataPosition::where('vessel_id', $ais_vessel->id)->first();
        }
    }

    public function infolist(Infolist $infolist): Infolist
    {
        return $infolist
            ->schema([
                TextEntry::make('title')
            ]);
    }
}
