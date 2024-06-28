<?php

namespace App\Filament\Resources;

use App\Filament\Resources\PelindoBongkarMuatResource\Pages;
use App\Filament\Resources\PelindoBongkarMuatResource\RelationManagers;
use App\Models\PelindoBongkarMuat;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Malzariey\FilamentDaterangepickerFilter\Filters\DateRangeFilter;
use Carbon\Carbon;

class PelindoBongkarMuatResource extends Resource
{
    protected static ?string $model = PelindoBongkarMuat::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\FileUpload::make('image_mulai')->image()->disk('minio')
                    ->imageEditor(),
                Forms\Components\FileUpload::make('image_sedang')->image()->disk('minio')
                    ->imageEditor(),
                Forms\Components\FileUpload::make('image_selesai')->image()->disk('minio')
                    ->imageEditor(),
                Forms\Components\FileUpload::make('image_mulai_2')->image()->disk('minio')
                    ->imageEditor(),
                Forms\Components\FileUpload::make('image_sedang_2')->image()->disk('minio')
                    ->imageEditor(),
                Forms\Components\FileUpload::make('image_selesai_2')->image()->disk('minio')
                    ->imageEditor(),
                Forms\Components\FileUpload::make('image_mulai_3')->image()->disk('minio')
                    ->imageEditor(),
                Forms\Components\FileUpload::make('image_sedang_3')->image()->disk('minio')
                    ->imageEditor(),
                Forms\Components\FileUpload::make('image_selesai_3')->image()->disk('minio')
                    ->imageEditor(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                //
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListPelindoBongkarMuats::route('/'),
            'create' => Pages\CreatePelindoBongkarMuat::route('/create'),
            'edit' => Pages\EditPelindoBongkarMuat::route('/{record}/edit'),
        ];
    }
}
