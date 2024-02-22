<?php

namespace App\Filament\Resources;

use App\Filament\Resources\RadarDataResource\Pages;
use App\Filament\Resources\RadarDataResource\RelationManagers;
use App\Models\RadarData;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class RadarDataResource extends Resource
{
    protected static ?string $model = RadarData::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    protected static ?string $navigationGroup = 'RADAR';

    protected static ?string $navigationLabel = 'Radar Data';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('name')
                    ->required()
                    ->maxLength(255),
                Forms\Components\TextInput::make('target_id')
                    ->required()
                    ->maxLength(255),
                Forms\Components\TextInput::make('latitude')
                    ->required()
                    ->numeric(),
                Forms\Components\TextInput::make('longitude')
                    ->required()
                    ->numeric(),
                Forms\Components\TextInput::make('altitude')
                    ->numeric(),
                Forms\Components\TextInput::make('speed')
                    ->numeric(),
                Forms\Components\TextInput::make('heading')
                    ->numeric(),
                Forms\Components\TextInput::make('course')
                    ->numeric(),
                Forms\Components\TextInput::make('range')
                    ->numeric(),
                Forms\Components\TextInput::make('bearing')
                    ->numeric(),
                Forms\Components\TextInput::make('distance_from_fak')
                    ->numeric(),
                Forms\Components\DateTimePicker::make('timestamp')
                    ->required(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('name')
                    ->searchable(),
                Tables\Columns\TextColumn::make('target_id')
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
                Tables\Columns\TextColumn::make('speed')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('heading')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('course')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('range')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('bearing')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('distance_from_fak')
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
            'index' => Pages\ListRadarData::route('/'),
            'create' => Pages\CreateRadarData::route('/create'),
            'edit' => Pages\EditRadarData::route('/{record}/edit'),
        ];
    }
}
