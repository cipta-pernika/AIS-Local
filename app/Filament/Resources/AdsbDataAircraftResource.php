<?php

namespace App\Filament\Resources;

use App\Filament\Resources\AdsbDataAircraftResource\Pages;
use App\Filament\Resources\AdsbDataAircraftResource\RelationManagers;
use App\Models\AdsbDataAircraft;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class AdsbDataAircraftResource extends Resource
{
    protected static ?string $model = AdsbDataAircraft::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    protected static ?string $navigationGroup = 'ADS-B';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('hex_ident')
                    ->required()
                    ->maxLength(255),
                Forms\Components\TextInput::make('manufacturer')
                    ->maxLength(255),
                Forms\Components\TextInput::make('model')
                    ->maxLength(255),
                Forms\Components\TextInput::make('registration')
                    ->maxLength(255),
                Forms\Components\TextInput::make('ownop')
                    ->maxLength(255),
                Forms\Components\TextInput::make('callsign')
                    ->maxLength(255),
                Forms\Components\TextInput::make('year')
                    ->maxLength(255),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('hex_ident')
                    ->searchable(),
                Tables\Columns\TextColumn::make('manufacturer')
                    ->searchable(),
                Tables\Columns\TextColumn::make('model')
                    ->searchable(),
                Tables\Columns\TextColumn::make('registration')
                    ->searchable(),
                Tables\Columns\TextColumn::make('ownop')
                    ->searchable(),
                Tables\Columns\TextColumn::make('callsign')
                    ->searchable(),
                Tables\Columns\TextColumn::make('year')
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
            'index' => Pages\ListAdsbDataAircraft::route('/'),
            'create' => Pages\CreateAdsbDataAircraft::route('/create'),
            'edit' => Pages\EditAdsbDataAircraft::route('/{record}/edit'),
        ];
    }
}
