<?php

namespace App\Filament\Pages;

use Filament\Pages\Page;

class CekPosisi extends Page
{
    protected static ?string $navigationIcon = 'heroicon-o-document-text';

    protected static string $view = 'filament.pages.cek-posisi';

    public static function shouldRegisterNavigation(): bool
    {
        return false;
    }
}
