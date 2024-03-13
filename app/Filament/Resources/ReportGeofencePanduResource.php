<?php

namespace App\Filament\Resources;

use App\Filament\Resources\ReportGeofencePanduResource\Pages;
use App\Filament\Resources\ReportGeofencePanduResource\RelationManagers;
use App\Models\ReportGeofencePandu;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class ReportGeofencePanduResource extends Resource
{
    protected static ?string $model = ReportGeofencePandu::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    protected static ?string $navigationGroup = 'Geofence';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Select::make('ais_data_position_id')
                    ->relationship('aisDataPosition', 'id'),
                Forms\Components\Select::make('geofence_id')
                    ->relationship('geofence', 'id'),
                Forms\Components\TextInput::make('mmsi')
                    ->maxLength(255),
                Forms\Components\TextInput::make('nama_kapal')
                    ->maxLength(255),
                Forms\Components\TextInput::make('nomor_spk_pandu')
                    ->maxLength(255),
                Forms\Components\DateTimePicker::make('in'),
                Forms\Components\DateTimePicker::make('out'),
                Forms\Components\TextInput::make('total_time')
                    ->maxLength(255),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('aisDataPosition.vessel.mmsi')
                    ->label('MMSI')
                    ->searchable()
                    ->sortable(),
                Tables\Columns\TextColumn::make('aisDataPosition.vessel.vessel_name')
                    ->searchable()
                    ->sortable(),
                Tables\Columns\TextColumn::make('geofence.geofence_name')
                    ->searchable()
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('nomor_spk_pandu')
                    ->searchable(),
                Tables\Columns\TextColumn::make('in')
                    ->dateTime()
                    ->sortable(),
                Tables\Columns\TextColumn::make('out')
                    ->dateTime()
                    ->sortable(),
                Tables\Columns\TextColumn::make('total_time')
                    ->searchable(),
                Tables\Columns\TextColumn::make('deleted_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
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
                // Tables\Actions\EditAction::make(),
            ])
            ->bulkActions([
                // Tables\Actions\BulkActionGroup::make([
                //     Tables\Actions\DeleteBulkAction::make(),
                // ]),
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
            'index' => Pages\ListReportGeofencePandus::route('/'),
            'create' => Pages\CreateReportGeofencePandu::route('/create'),
            'edit' => Pages\EditReportGeofencePandu::route('/{record}/edit'),
        ];
    }
}
