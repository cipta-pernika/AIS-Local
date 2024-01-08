<?php

namespace App\Filament\Resources;

use App\Filament\Resources\InaportnetPergerakanKapalResource\Pages;
use App\Filament\Resources\InaportnetPergerakanKapalResource\RelationManagers;
use App\Models\InaportnetPergerakanKapal;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class InaportnetPergerakanKapalResource extends Resource
{
    protected static ?string $model = InaportnetPergerakanKapal::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    protected static ?string $navigationGroup = 'Big Data';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('no_pkk')
                    ->required()
                    ->maxLength(255),
                Forms\Components\TextInput::make('ais_data_vessel_id')
                    ->numeric(),
                Forms\Components\TextInput::make('nama_kapal')
                    ->maxLength(255),
                Forms\Components\TextInput::make('jenis_layanan')
                    ->maxLength(255),
                Forms\Components\TextInput::make('nama_negara')
                    ->maxLength(255),
                Forms\Components\TextInput::make('tipe_kapal')
                    ->maxLength(255),
                Forms\Components\TextInput::make('nama_perusahaan')
                    ->maxLength(255),
                Forms\Components\TextInput::make('tgl_tiba')
                    ->maxLength(255),
                Forms\Components\TextInput::make('tgl_brangkat')
                    ->maxLength(255),
                Forms\Components\TextInput::make('bendera')
                    ->maxLength(255),
                Forms\Components\TextInput::make('gt_kapal')
                    ->numeric(),
                Forms\Components\TextInput::make('dwt')
                    ->numeric(),
                Forms\Components\TextInput::make('no_imo')
                    ->maxLength(255),
                Forms\Components\TextInput::make('call_sign')
                    ->maxLength(255),
                Forms\Components\TextInput::make('nakhoda')
                    ->maxLength(255),
                Forms\Components\TextInput::make('jenis_trayek')
                    ->maxLength(255),
                Forms\Components\TextInput::make('pelabuhan_asal')
                    ->maxLength(255),
                Forms\Components\TextInput::make('pelabuhan_tujuan')
                    ->maxLength(255),
                Forms\Components\TextInput::make('lokasi_lambat_labuh')
                    ->maxLength(255),
                Forms\Components\TextInput::make('waktu_respon')
                    ->maxLength(255),
                Forms\Components\TextInput::make('nomor_spog')
                    ->maxLength(255),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('no_pkk')
                    ->searchable(),
                Tables\Columns\TextColumn::make('ais_data_vessel_id')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('nama_kapal')
                    ->searchable(),
                Tables\Columns\TextColumn::make('jenis_layanan')
                    ->searchable(),
                Tables\Columns\TextColumn::make('nama_negara')
                    ->searchable(),
                Tables\Columns\TextColumn::make('tipe_kapal')
                    ->searchable(),
                Tables\Columns\TextColumn::make('nama_perusahaan')
                    ->searchable(),
                Tables\Columns\TextColumn::make('tgl_tiba')
                    ->searchable(),
                Tables\Columns\TextColumn::make('tgl_brangkat')
                    ->searchable(),
                Tables\Columns\TextColumn::make('bendera')
                    ->searchable(),
                Tables\Columns\TextColumn::make('gt_kapal')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('dwt')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('no_imo')
                    ->searchable(),
                Tables\Columns\TextColumn::make('call_sign')
                    ->searchable(),
                Tables\Columns\TextColumn::make('nakhoda')
                    ->searchable(),
                Tables\Columns\TextColumn::make('jenis_trayek')
                    ->searchable(),
                Tables\Columns\TextColumn::make('pelabuhan_asal')
                    ->searchable(),
                Tables\Columns\TextColumn::make('pelabuhan_tujuan')
                    ->searchable(),
                Tables\Columns\TextColumn::make('lokasi_lambat_labuh')
                    ->searchable(),
                Tables\Columns\TextColumn::make('waktu_respon')
                    ->searchable(),
                Tables\Columns\TextColumn::make('nomor_spog')
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
            'index' => Pages\ListInaportnetPergerakanKapals::route('/'),
            'create' => Pages\CreateInaportnetPergerakanKapal::route('/create'),
            'edit' => Pages\EditInaportnetPergerakanKapal::route('/{record}/edit'),
        ];
    }
}
