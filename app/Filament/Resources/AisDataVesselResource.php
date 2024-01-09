<?php

namespace App\Filament\Resources;

use App\Filament\Resources\AisDataVesselResource\Pages;
use App\Filament\Resources\AisDataVesselResource\RelationManagers;
use pxlrbt\FilamentExcel\Actions\Tables\ExportBulkAction;
use App\Models\AisDataVessel;
use BezhanSalleh\FilamentShield\Contracts\HasShieldPermissions;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class AisDataVesselResource extends Resource implements HasShieldPermissions
{
    protected static ?string $model = AisDataVessel::class;

    protected static ?string $navigationIcon = 'heroicon-s-paper-airplane';

    protected static ?string $navigationGroup = 'AIS';

    protected static ?string $recordTitleAttribute = 'vessel_name';

    public static function getGloballySearchableAttributes(): array
    {
        return ['vessel_name', 'mmsi', 'imo', 'callsign'];
    }

    public static function getPermissionPrefixes(): array
    {
        return [
            'view',
            'view_any',
            'create',
            'update',
            'delete',
            'delete_any',
            'publish'
        ];
    }

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
                Tables\Columns\TextColumn::make('no_pkk')->sortable(),
                Tables\Columns\TextColumn::make('jenis_layanan')->sortable(),
                Tables\Columns\TextColumn::make('nama_negara')->sortable(),
                Tables\Columns\TextColumn::make('tipe_kapal')->sortable(),
                Tables\Columns\TextColumn::make('nama_perusahaan')->sortable(),
                Tables\Columns\TextColumn::make('tgl_tiba')->sortable(),
                Tables\Columns\TextColumn::make('tgl_brangkat')->sortable(),
                Tables\Columns\TextColumn::make('bendera'),
                Tables\Columns\TextColumn::make('gt_kapal')->sortable(),
                Tables\Columns\TextColumn::make('dwt'),
                Tables\Columns\TextColumn::make('nakhoda'),
                Tables\Columns\TextColumn::make('jenis_trayek'),
                Tables\Columns\TextColumn::make('pelabuhan_asal')->sortable(),
                Tables\Columns\TextColumn::make('pelabuhan_tujuan'),
                Tables\Columns\TextColumn::make('lokasi_lambat_labuh'),
                Tables\Columns\TextColumn::make('nomor_spog'),
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
