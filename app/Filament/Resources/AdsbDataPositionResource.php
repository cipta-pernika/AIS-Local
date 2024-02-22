<?php

namespace App\Filament\Resources;

use App\Filament\Resources\AdsbDataPositionResource\Pages;
use App\Filament\Resources\AdsbDataPositionResource\RelationManagers;
use App\Models\AdsbDataPosition;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class AdsbDataPositionResource extends Resource
{
    protected static ?string $model = AdsbDataPosition::class;

    protected static ?string $navigationIcon = 'heroicon-o-cursor-arrow-ripple';

    protected static ?string $navigationGroup = 'ADS-B';

    public static function shouldRegisterNavigation(): bool
    {
        return false;
    }

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('sensor_data_id')
                    ->required()
                    ->numeric(),
                Forms\Components\TextInput::make('aircraft_id')
                    ->numeric(),
                Forms\Components\TextInput::make('flight_id')
                    ->maxLength(255),
                Forms\Components\TextInput::make('latitude')
                    ->numeric(),
                Forms\Components\TextInput::make('longitude')
                    ->numeric(),
                Forms\Components\TextInput::make('altitude')
                    ->numeric(),
                Forms\Components\TextInput::make('ground_speed')
                    ->numeric(),
                Forms\Components\TextInput::make('heading')
                    ->numeric(),
                Forms\Components\TextInput::make('vertical_rate')
                    ->numeric(),
                Forms\Components\TextInput::make('track')
                    ->numeric(),
                Forms\Components\DateTimePicker::make('timestamp')
                    ->required(),
                Forms\Components\TextInput::make('transmission_type')
                    ->maxLength(255),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('sensor_data_id')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('aircraft_id')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('flight_id')
                    ->searchable(),
                Tables\Columns\TextColumn::make('latitude')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('longitude')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('altitude')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('ground_speed')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('heading')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('vertical_rate')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('track')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('timestamp')
                    ->dateTime()
                    ->sortable(),
                Tables\Columns\TextColumn::make('transmission_type')
                    ->searchable(),
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
            'index' => Pages\ListAdsbDataPositions::route('/'),
            'create' => Pages\CreateAdsbDataPosition::route('/create'),
            'edit' => Pages\EditAdsbDataPosition::route('/{record}/edit'),
        ];
    }
}
