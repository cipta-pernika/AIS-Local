<?php

namespace App\Filament\Resources;

use App\Filament\Resources\SensorDataResource\Pages;
use App\Filament\Resources\SensorDataResource\RelationManagers;
use App\Models\SensorData;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class SensorDataResource extends Resource
{
    protected static ?string $model = SensorData::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    protected static ?string $navigationGroup = 'Logs';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('sensor_id')
                    ->required()
                    ->numeric(),
                Forms\Components\Textarea::make('payload')
                    ->required()
                    ->maxLength(65535)
                    ->columnSpanFull(),
                Forms\Components\DateTimePicker::make('timestamp')
                    ->required(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('sensor_id')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('timestamp')
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
            'index' => Pages\ListSensorData::route('/'),
            'create' => Pages\CreateSensorData::route('/create'),
            'edit' => Pages\EditSensorData::route('/{record}/edit'),
        ];
    }
}
