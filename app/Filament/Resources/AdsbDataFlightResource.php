<?php

namespace App\Filament\Resources;

use App\Filament\Resources\AdsbDataFlightResource\Pages;
use App\Filament\Resources\AdsbDataFlightResource\RelationManagers;
use App\Models\AdsbDataFlight;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class AdsbDataFlightResource extends Resource
{
    protected static ?string $model = AdsbDataFlight::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    protected static ?string $navigationGroup = 'ADS-B';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('aircraft_id')
                    ->numeric(),
                Forms\Components\TextInput::make('flight_number')
                    ->maxLength(255),
                Forms\Components\DatePicker::make('date'),
                Forms\Components\TextInput::make('from')
                    ->maxLength(255),
                Forms\Components\TextInput::make('to')
                    ->maxLength(255),
                Forms\Components\TextInput::make('flight_time')
                    ->numeric(),
                Forms\Components\DateTimePicker::make('std'),
                Forms\Components\DateTimePicker::make('atd'),
                Forms\Components\DateTimePicker::make('sta'),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('aircraft_id')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('flight_number')
                    ->searchable(),
                Tables\Columns\TextColumn::make('date')
                    ->date()
                    ->sortable(),
                Tables\Columns\TextColumn::make('from')
                    ->searchable(),
                Tables\Columns\TextColumn::make('to')
                    ->searchable(),
                Tables\Columns\TextColumn::make('flight_time')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('std')
                    ->dateTime()
                    ->sortable(),
                Tables\Columns\TextColumn::make('atd')
                    ->dateTime()
                    ->sortable(),
                Tables\Columns\TextColumn::make('sta')
                    ->dateTime()
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
            'index' => Pages\ListAdsbDataFlights::route('/'),
            'create' => Pages\CreateAdsbDataFlight::route('/create'),
            'edit' => Pages\EditAdsbDataFlight::route('/{record}/edit'),
        ];
    }
}
