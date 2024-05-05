<?php

namespace App\Filament\Resources;

use App\Filament\Resources\GeofenceTypeResource\Pages;
use App\Filament\Resources\GeofenceTypeResource\RelationManagers;
use App\Models\GeofenceType;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class GeofenceTypeResource extends Resource
{
    protected static ?string $model = GeofenceType::class;

    protected static ?string $navigationIcon = 'heroicon-c-cursor-arrow-ripple';

    protected static ?string $navigationGroup = 'Geofence';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('name')
                    ->required()
                    ->maxLength(255),
                Forms\Components\TextInput::make('base_price')
                    ->numeric(),
                Forms\Components\Select::make('uom')
                    ->options([
                        'Minutes' => 'Minutes',
                        'Hours' => 'Hours',
                        'Days' => 'Days',
                    ])
                    ->native(false),
                Forms\Components\Select::make('vessel_type')
                    ->native(false)
                    ->multiple()
                    ->options([
                        'Fishing' => 'Fishing',
                        'Tug' => 'Tug',
                        'Cargo' => 'Cargo',
                    ]),
                Forms\Components\TextInput::make('speed')
                    ->numeric(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('name')
                    ->searchable(),
                Tables\Columns\TextColumn::make('base_price')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('uom')
                    ->searchable(),
                Tables\Columns\TextColumn::make('vessel_type')
                    ->searchable(),
                Tables\Columns\TextColumn::make('speed')
                    ->numeric()
                    ->sortable(),
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
            'index' => Pages\ListGeofenceTypes::route('/'),
            'create' => Pages\CreateGeofenceType::route('/create'),
            'edit' => Pages\EditGeofenceType::route('/{record}/edit'),
        ];
    }
}
