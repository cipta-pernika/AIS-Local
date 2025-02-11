<?php

namespace App\Filament\Resources;

use App\Filament\Resources\SensorResource\Pages;
use App\Filament\Resources\SensorResource\RelationManagers;
use App\Models\Sensor;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class SensorResource extends Resource
{
    protected static ?string $model = Sensor::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    protected static ?string $navigationGroup = 'Informasi Penting';

    protected static ?int $navigationSort = 97;

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('datalogger_id')
                    ->required()
                    ->numeric(),
                Forms\Components\TextInput::make('name')
                    ->required()
                    ->maxLength(255),
                Forms\Components\TextInput::make('status')
                    ->required()
                    ->maxLength(255),
                Forms\Components\TextInput::make('interval')
                    ->required()
                    ->numeric(),
                Forms\Components\TextInput::make('jarak')
                    ->required()
                    ->numeric(),
                Forms\Components\TextInput::make('jumlah_data')
                    ->required()
                    ->numeric(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('datalogger.name')
                    ->label('Datalogger')
                    ->sortable(),
                Tables\Columns\TextColumn::make('name')
                    ->searchable(),
                Tables\Columns\TextColumn::make('status')
                    ->searchable(),
                Tables\Columns\TextColumn::make('interval')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('jarak')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('jumlah_data')
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
            'index' => Pages\ListSensors::route('/'),
            'create' => Pages\CreateSensor::route('/create'),
            'edit' => Pages\EditSensor::route('/{record}/edit'),
        ];
    }
}
