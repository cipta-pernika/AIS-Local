<?php

namespace App\Filament\Resources;

use App\Filament\Resources\ReportGeofenceResource\Pages;
use App\Filament\Resources\ReportGeofenceResource\RelationManagers;
use AlperenErsoy\FilamentExport\Actions\FilamentExportBulkAction;
use App\Models\ReportGeofence;
use Carbon\Carbon;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Tables\Actions\Action;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Malzariey\FilamentDaterangepickerFilter\Filters\DateRangeFilter;

class ReportGeofenceResource extends Resource
{
    protected static ?string $model = ReportGeofence::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    protected static ?string $navigationGroup = 'Geofence';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Select::make('event_id')
                    ->relationship('event', 'name')
                    ->required(),
                Forms\Components\Select::make('ais_data_position_id')
                    ->relationship('aisDataPosition', 'id'),
                Forms\Components\Select::make('geofence_id')
                    ->relationship('geofence', 'id'),
                Forms\Components\DateTimePicker::make('in')
                    ->required(),
                Forms\Components\DateTimePicker::make('out')
                    ->required(),
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
                Tables\Columns\TextColumn::make('in')
                    ->dateTime()
                    ->searchable()
                    ->sortable(),
                Tables\Columns\TextColumn::make('out')
                    ->searchable()
                    ->dateTime()
                    ->sortable(),
                Tables\Columns\TextColumn::make('total_time')
                    ->label('Total Time (Minute)')
                    ->sortable(),
                Tables\Columns\TextColumn::make('aisDataPosition.vessel.no_pkk')
                    ->searchable()
                    ->label('No PKK')
                    ->sortable(),
                Tables\Columns\TextColumn::make('aisDataPosition.vessel.no_pandu')
                    ->searchable()
                    ->label('No Pandu')
                    ->sortable(),
                Tables\Columns\TextColumn::make('aisDataPosition.vessel.nama_pandu')
                    ->searchable()
                    ->label('Nama Pandu')
                    ->sortable(),
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
                Tables\Filters\SelectFilter::make('geofence')
                    ->multiple()
                    ->relationship('geofence', 'geofence_name')
                    ->preload()
                    ->searchable(),
                DateRangeFilter::make('created_at')->startDate(Carbon::now()->subDays(7))->endDate(Carbon::now()),
            ])
            ->actions([
                // Tables\Actions\EditAction::make(),
                Action::make('playback')
                    ->label('Playback')->url(fn (Model $record): string => route('playback', ['record' => $record, 'source' => 'report-geofence']))->openUrlInNewTab()
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    // Tables\Actions\DeleteBulkAction::make(),
                    FilamentExportBulkAction::make('export')
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
            'index' => Pages\ListReportGeofences::route('/'),
            'create' => Pages\CreateReportGeofence::route('/create'),
            'edit' => Pages\EditReportGeofence::route('/{record}/edit'),
        ];
    }
}
