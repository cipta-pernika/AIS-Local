<?php

namespace App\Filament\Pages;

use Filament\Pages\Page;

class BargePairingTo extends Page
{
    protected static ?string $navigationIcon = 'heroicon-c-arrow-top-right-on-square';

    protected static string $view = 'filament.pages.barge-pairing-to';

    protected static ?string $navigationGroup = 'Barge';

    protected ?string $subheading = 'Daftar Tongkang yg belum berpasangan';
}
