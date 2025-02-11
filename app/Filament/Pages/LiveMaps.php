<?php

namespace App\Filament\Pages;

use Filament\Pages\Page;

class LiveMaps extends Page
{
    protected static ?string $navigationIcon = 'heroicon-o-document-text';

    protected static string $view = 'filament.pages.live-maps';

    public static function shouldRegisterNavigation(): bool
    {
        return false;
    }
}
