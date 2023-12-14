<?php

namespace App\Filament\Resources;

use App\Filament\Resources\MapSettingResource\Pages;
use App\Filament\Resources\MapSettingResource\RelationManagers;
use App\Models\MapSetting;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class MapSettingResource extends Resource
{
    protected static ?string $model = MapSetting::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Select::make('user_id')
                    ->relationship('user', 'name')
                    ->native(false)
                    ->required(),
                Forms\Components\Select::make('distance_unit')
                    ->options([
                        'km' => 'KM',
                        'mile' => 'MILE',
                        'nauticalmile' => 'NAUTICAL MILE',
                    ])->native(false),
                Forms\Components\Select::make('speed_unit')
                    ->options([
                        'km/h' => 'Kilometre per hour',
                        'mile/h' => 'Mile per hour',
                        'knot' => 'Knot',
                    ])->native(false),
                Forms\Components\Radio::make('breadcrumb')
                    ->options([
                        'duration' => 'BREADCRUMB BY DURATION',
                        'point' => 'BREADCRUMB BY POINT',
                    ])
                    ->descriptions([
                        'duration' => 'Selecting this option will enable breadcrumb tracking based on time duration.',
                        'point' => 'Selecting this option will enable breadcrumb tracking based on points.',
                    ]),
                Forms\Components\TextInput::make('breadcrumb_point')->numeric()
                    ->step(10)
                    ->minValue(10)
                    ->maxValue(200),
                Forms\Components\TextInput::make('time_zone')
                    ->maxLength(255),
                Forms\Components\Select::make('coordinate_format')
                    ->options([
                        'dms' => 'Degrees Minutes Seconds (DMS)',
                        'decimal' => 'Decimal',
                    ])->native(false),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('user.name')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('distance_unit')
                    ->searchable(),
                Tables\Columns\TextColumn::make('speed_unit')
                    ->searchable(),
                Tables\Columns\TextColumn::make('time_zone')
                    ->searchable(),
                Tables\Columns\TextColumn::make('coordinate_format')
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
                    // Tables\Actions\DeleteBulkAction::make(),
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
            'index' => Pages\ListMapSettings::route('/'),
            'create' => Pages\CreateMapSetting::route('/create'),
            'edit' => Pages\EditMapSetting::route('/{record}/edit'),
        ];
    }
}
