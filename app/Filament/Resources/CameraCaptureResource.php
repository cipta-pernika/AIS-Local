<?php

namespace App\Filament\Resources;

use App\Filament\Resources\CameraCaptureResource\Pages;
use App\Filament\Resources\CameraCaptureResource\RelationManagers;
use App\Models\CameraCapture;
use Filament\Tables\Columns\ViewColumn;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class CameraCaptureResource extends Resource
{
    protected static ?string $model = CameraCapture::class;

    protected static ?string $navigationIcon = 'heroicon-s-camera';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('pelabuhan_id')
                    ->numeric(),
                Forms\Components\TextInput::make('geofence_id')
                    ->numeric(),
                Forms\Components\FileUpload::make('image')
                    ->image()
                    ->required(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('pelabuhan.name')
                    ->sortable(),
                Tables\Columns\TextColumn::make('geofence.geofence_name')
                    ->sortable(),
                Tables\Columns\ViewColumn::make('image')->view('filament.tables.columns.image'),
                Tables\Columns\TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('updated_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                //
            ])
            ->actions([
                // Tables\Actions\EditAction::make(),
            ])
            ->bulkActions([
                // Tables\Actions\BulkActionGroup::make([
                //     Tables\Actions\DeleteBulkAction::make(),
                // ]),
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
            'index' => Pages\ListCameraCaptures::route('/'),
            'create' => Pages\CreateCameraCapture::route('/create'),
            'edit' => Pages\EditCameraCapture::route('/{record}/edit'),
        ];
    }
}
