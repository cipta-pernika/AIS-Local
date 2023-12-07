<?php

namespace App\Filament\Resources;

use App\Filament\Resources\AisDataVesselResource\Pages;
use App\Filament\Resources\AisDataVesselResource\RelationManagers;
use pxlrbt\FilamentExcel\Actions\Tables\ExportBulkAction;
use App\Models\AisDataVessel;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class AisDataVesselResource extends Resource
{
    protected static ?string $model = AisDataVessel::class;

    protected static ?string $navigationIcon = 'heroicon-s-paper-airplane';

    protected static ?string $navigationGroup = 'AIS';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('vessel_name'),
                Forms\Components\Select::make('vessel_type')->options([
                    'Fishing' => 'Fishing',
                    'Tug' => 'Tug',
                    'Cargo' => 'Cargo',
                ])->native(false),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('vessel_name')->searchable(),
                Tables\Columns\TextColumn::make('vessel_type')->sortable(),
                Tables\Columns\TextColumn::make('mmsi')->searchable(),
                Tables\Columns\TextColumn::make('imo')->searchable(),
                Tables\Columns\TextColumn::make('callsign')->searchable(),
                Tables\Columns\TextColumn::make('draught'),
                Tables\Columns\TextColumn::make('reported_destination'),
                Tables\Columns\TextColumn::make('reported_eta')->sortable(),
                Tables\Columns\TextColumn::make('dimension_to_bow'),
                Tables\Columns\TextColumn::make('dimension_to_stern'),
                Tables\Columns\TextColumn::make('dimension_to_port'),
                Tables\Columns\TextColumn::make('dimension_to_starboard'),
                Tables\Columns\TextColumn::make('type_number'),
            ])
            ->filters([
                Tables\Filters\SelectFilter::make('vessel_type')
                ->options([
                    'Fishing' => 'Fishing',
                    'Tug' => 'Tug',
                    'Cargo' => 'Cargo',
                ]),
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                    ExportBulkAction::make()
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
            'index' => Pages\ListAisDataVessels::route('/'),
            'create' => Pages\CreateAisDataVessel::route('/create'),
            'edit' => Pages\EditAisDataVessel::route('/{record}/edit'),
        ];
    }
}
