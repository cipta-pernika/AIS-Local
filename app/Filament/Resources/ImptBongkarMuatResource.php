<?php

namespace App\Filament\Resources;

use App\Filament\Resources\ImptBongkarMuatResource\Pages;
use App\Filament\Resources\ImptBongkarMuatResource\RelationManagers;
use App\Models\ImptBongkarMuat;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Filament\Tables\Columns\ViewColumn;

class ImptBongkarMuatResource extends Resource
{
    protected static ?string $model = ImptBongkarMuat::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('id_impt_bongkar_muat')
                    ->required()
                    ->numeric(),
                Forms\Components\TextInput::make('no_pkk')
                    ->maxLength(255),
                Forms\Components\TextInput::make('rkbm')
                    ->maxLength(255),
                Forms\Components\TextInput::make('ais_data_vessel_id')
                    ->numeric(),
                Forms\Components\TextInput::make('nomor_registrasi_cargo')
                    ->maxLength(255),
                Forms\Components\TextInput::make('nama_kapal')
                    ->maxLength(255),
                Forms\Components\TextInput::make('nama_perusahaan')
                    ->maxLength(255),
                Forms\Components\TextInput::make('pemilik_barang')
                    ->maxLength(255),
                Forms\Components\TextInput::make('jenis')
                    ->maxLength(255),
                Forms\Components\TextInput::make('jumlah_tonase')
                    ->numeric(),
                Forms\Components\TextInput::make('jumlah_biaya')
                    ->numeric(),
                Forms\Components\TextInput::make('jumlah_pnbp')
                    ->numeric(),
                Forms\Components\TextInput::make('kegiatan')
                    ->maxLength(255),
                Forms\Components\DateTimePicker::make('tanggal_mulai'),
                Forms\Components\DateTimePicker::make('tanggal_selesai'),
                Forms\Components\DateTimePicker::make('date'),
                Forms\Components\Textarea::make('image_mulai')
                    ->columnSpanFull(),
                Forms\Components\Textarea::make('image_sedang')
                    ->columnSpanFull(),
                Forms\Components\Textarea::make('image_selesai')
                    ->columnSpanFull(),
                Forms\Components\Textarea::make('image_mulai_2')
                    ->columnSpanFull(),
                Forms\Components\Textarea::make('image_sedang_2')
                    ->columnSpanFull(),
                Forms\Components\Textarea::make('image_selesai_2')
                    ->columnSpanFull(),
                Forms\Components\Textarea::make('image_mulai_3')
                    ->columnSpanFull(),
                Forms\Components\Textarea::make('image_sedang_3')
                    ->columnSpanFull(),
                Forms\Components\Textarea::make('image_selesai_3')
                    ->columnSpanFull(),
                Forms\Components\TextInput::make('no_pkk_assign')
                    ->maxLength(255),
                Forms\Components\TextInput::make('mmsi')
                    ->maxLength(255),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('id_impt_bongkar_muat')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('no_pkk')
                    ->searchable(),
                Tables\Columns\TextColumn::make('rkbm')
                    ->searchable(),
                Tables\Columns\TextColumn::make('ais_data_vessel_id')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('nomor_registrasi_cargo')
                    ->searchable(),
                Tables\Columns\TextColumn::make('nama_kapal')
                    ->searchable(),
                Tables\Columns\TextColumn::make('nama_perusahaan')
                    ->searchable(),
                Tables\Columns\TextColumn::make('pemilik_barang')
                    ->searchable(),
                Tables\Columns\TextColumn::make('jenis')
                    ->searchable(),
                Tables\Columns\TextColumn::make('jumlah_tonase')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('jumlah_biaya')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('jumlah_pnbp')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('kegiatan')
                    ->searchable(),
                Tables\Columns\TextColumn::make('tanggal_mulai')
                    ->dateTime()
                    ->sortable(),
                Tables\Columns\TextColumn::make('tanggal_selesai')
                    ->dateTime()
                    ->sortable(),
                Tables\Columns\TextColumn::make('date')
                    ->dateTime()
                    ->sortable(),
                Tables\Columns\TextColumn::make('no_pkk_assign')
                    ->searchable(),
                Tables\Columns\TextColumn::make('mmsi')
                    ->searchable(),
                ViewColumn::make('image_mulai')
                    ->view('filament.tables.columns.image-column')
                    ->label('Mulai Bongkar/Muat'),
                ViewColumn::make('image_sedang')
                    ->view('filament.tables.columns.image-column-sedang')
                    ->label('Sedang Bongkar/Muat'),
                ViewColumn::make('image_selesai')
                    ->view('filament.tables.columns.image-column-akhir')
                    ->label('Selesai Bongkar/Muat'),
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
            'index' => Pages\ListImptBongkarMuats::route('/'),
            'create' => Pages\CreateImptBongkarMuat::route('/create'),
            'edit' => Pages\EditImptBongkarMuat::route('/{record}/edit'),
        ];
    }
}
