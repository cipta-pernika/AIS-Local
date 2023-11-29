<?php

namespace App\Filament\Resources;

use App\Filament\Resources\EventTrackingResource\Pages;
use App\Filament\Resources\EventTrackingResource\RelationManagers;
use App\Models\EventTracking;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class EventTrackingResource extends Resource
{
    protected static ?string $model = EventTracking::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Select::make('asset_id')
                    ->relationship('asset', 'id'),
                Forms\Components\Select::make('event_id')
                    ->relationship('event', 'name')
                    ->required(),
                Forms\Components\Select::make('ais_data_position_id')
                    ->relationship('aisDataPosition', 'id'),
                Forms\Components\TextInput::make('notes')
                    ->maxLength(255),
                Forms\Components\TextInput::make('mmsi')
                    ->maxLength(255),
                Forms\Components\TextInput::make('ship_name')
                    ->maxLength(255),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('asset.id')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('event.name')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('aisDataPosition.id')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('notes')
                    ->searchable(),
                Tables\Columns\TextColumn::make('mmsi')
                    ->searchable(),
                Tables\Columns\TextColumn::make('ship_name')
                    ->searchable(),
                Tables\Columns\TextColumn::make('deleted_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
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
            'index' => Pages\ListEventTrackings::route('/'),
            'create' => Pages\CreateEventTracking::route('/create'),
            'edit' => Pages\EditEventTracking::route('/{record}/edit'),
        ];
    }
}
