<?php

namespace App\Filament\Resources;

use App\Filament\Resources\ImptPenggunaanAlatResource\Pages;
use App\Filament\Resources\ImptPenggunaanAlatResource\RelationManagers;
use App\Models\ImptPenggunaanAlat;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class ImptPenggunaanAlatResource extends Resource
{
    protected static ?string $model = ImptPenggunaanAlat::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('impt_source_id')
                    ->required()
                    ->numeric(),
                Forms\Components\TextInput::make('ais_data_vessel_id')
                    ->numeric(),
                Forms\Components\TextInput::make('no_pkk')
                    ->required()
                    ->maxLength(255),
                Forms\Components\TextInput::make('nama_kapal')
                    ->maxLength(255),
                Forms\Components\TextInput::make('nomor_te')
                    ->maxLength(255),
                Forms\Components\TextInput::make('spog')
                    ->maxLength(255),
                Forms\Components\TextInput::make('nama_floting_crane')
                    ->maxLength(255),
                Forms\Components\TextInput::make('gt')
                    ->maxLength(255),
                Forms\Components\TextInput::make('agen_perusahaan_te')
                    ->maxLength(255),
                Forms\Components\DateTimePicker::make('tanggal_mulai_kegiatan'),
                Forms\Components\DateTimePicker::make('tanggal_selesai_kegiatan'),
                Forms\Components\TextInput::make('lama_penggunaaan')
                    ->maxLength(255),
                Forms\Components\TextInput::make('jumlah_biaya')
                    ->numeric(),
                Forms\Components\TextInput::make('jumlah_pnbp')
                    ->numeric(),
                Forms\Components\DateTimePicker::make('date'),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('impt_source_id')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('ais_data_vessel_id')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('no_pkk')
                    ->searchable(),
                Tables\Columns\TextColumn::make('nama_kapal')
                    ->searchable(),
                Tables\Columns\TextColumn::make('nomor_te')
                    ->searchable(),
                Tables\Columns\TextColumn::make('spog')
                    ->searchable(),
                Tables\Columns\TextColumn::make('nama_floting_crane')
                    ->searchable(),
                Tables\Columns\TextColumn::make('gt')
                    ->searchable(),
                Tables\Columns\TextColumn::make('agen_perusahaan_te')
                    ->searchable(),
                Tables\Columns\TextColumn::make('tanggal_mulai_kegiatan')
                    ->dateTime()
                    ->sortable(),
                Tables\Columns\TextColumn::make('tanggal_selesai_kegiatan')
                    ->dateTime()
                    ->sortable(),
                Tables\Columns\TextColumn::make('lama_penggunaaan')
                    ->searchable(),
                Tables\Columns\TextColumn::make('jumlah_biaya')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('jumlah_pnbp')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('date')
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
            'index' => Pages\ListImptPenggunaanAlats::route('/'),
            'create' => Pages\CreateImptPenggunaanAlat::route('/create'),
            'edit' => Pages\EditImptPenggunaanAlat::route('/{record}/edit'),
        ];
    }
}
