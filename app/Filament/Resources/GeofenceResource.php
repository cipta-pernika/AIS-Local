<?php

namespace App\Filament\Resources;

use App\Filament\Resources\GeofenceResource\Pages;
use App\Filament\Resources\GeofenceResource\RelationManagers;
use App\Models\Geofence;
use App\Models\Pelabuhan;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class GeofenceResource extends Resource
{
    protected static ?string $model = Geofence::class;

    protected static ?string $navigationIcon = 'heroicon-o-globe-alt';

    protected static ?string $navigationGroup = 'Geofence';

    protected static ?string $recordTitleAttribute = 'geofence_name';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                // Forms\Components\TextInput::make('user_id')
                //     ->maxLength(255),
                Forms\Components\Select::make('pelabuhan_id')
                    ->native(false)
                    ->label('Pelabuhan')
                    ->multiple(false)->options(Pelabuhan::all()->pluck('name', 'id'))
                    ->searchable(),
                Forms\Components\TextInput::make('geofence_name')
                    ->maxLength(255),
                Forms\Components\Select::make('type')
                    ->options([
                        'both' => 'Both',
                        'in' => 'In',
                        'out' => 'Out',
                    ])
                    ->multiple(false)->native(false),
                Forms\Components\Select::make('type_geo')
                    ->options([
                        'polygon' => 'Polygon',
                        'rectangle' => 'Rectangle',
                        'circle' => 'Circle',
                    ])
                    ->multiple(false)->native(false),
                Forms\Components\TextInput::make('radius')
                    ->maxLength(255),
                Forms\Components\Textarea::make('geometry')
                    ->columnSpanFull(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('pelabuhan.name')
                    ->label('Pelabuhan')
                    ->sortable(),
                Tables\Columns\TextColumn::make('location.name')
                    ->label('Location/TERSUS')
                    ->sortable(),
                Tables\Columns\TextColumn::make('geofenceType.name')
                    ->label('Tipe Geofence')
                    ->sortable(),
                // Tables\Columns\TextColumn::make('user_id')
                //     ->searchable(),
                Tables\Columns\TextColumn::make('geofence_name')
                    ->searchable(),
                Tables\Columns\TextColumn::make('type')
                    ->searchable(),
                Tables\Columns\TextColumn::make('type_geo')
                    ->searchable(),
                Tables\Columns\TextColumn::make('radius')
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
                Tables\Filters\SelectFilter::make('pelabuhan_id')
                    ->options(Pelabuhan::all()->pluck('name', 'id')),
            ])
            ->actions([
                // Tables\Actions\EditAction::make(),
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
            'index' => Pages\ListGeofences::route('/'),
            'create' => Pages\CreateGeofence::route('/create'),
            'edit' => Pages\EditGeofence::route('/{record}/edit'),
        ];
    }
}
