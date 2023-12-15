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
use pxlrbt\FilamentExcel\Actions\Tables\ExportBulkAction;

class EventTrackingResource extends Resource
{
    protected static ?string $model = EventTracking::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    protected static ?string $navigationGroup = 'Events';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                // Forms\Components\Select::make('asset_id')
                //     ->relationship('asset', 'id'),
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
                // Tables\Columns\TextColumn::make('asset.id')
                //     ->numeric()
                //     ->sortable(),
                Tables\Columns\TextColumn::make('event.name')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('aisDataPosition.vessel.mmsi')
                    ->label('MMSI')
                    ->sortable(),
                Tables\Columns\TextColumn::make('aisDataPosition.vessel.vessel_name')
                    ->sortable(),
                Tables\Columns\TextColumn::make('geofence.geofence_name')
                    ->sortable(),
                Tables\Columns\TextColumn::make('aisDataPosition.speed')
                    ->label('Speed')
                    ->sortable(),
                Tables\Columns\TextColumn::make('aisDataPosition.latitude')
                    ->label('Latitude')
                    ->sortable(),
                Tables\Columns\TextColumn::make('aisDataPosition.longitude')
                    ->label('Longitude')
                    ->sortable(),
                Tables\Columns\TextColumn::make('aisDataPosition.created_at')
                    ->label('Timestamp')
                    ->sortable(),
            ])
            ->filters([
                Tables\Filters\SelectFilter::make('event')
                    ->multiple()
                    ->relationship('event', 'name')
                    ->preload()
                    ->searchable(),
                Tables\Filters\SelectFilter::make('geofence')
                    ->multiple()
                    ->relationship('geofence', 'geofence_name')
                    ->preload()
                    ->searchable(),
            ])
            ->actions([
                // Tables\Actions\EditAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                    ExportBulkAction::make()
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
