<?php

namespace App\Filament\Resources;

use App\Filament\Resources\PbkmKegiatanPemanduanResource\Pages;
use App\Filament\Resources\PbkmKegiatanPemanduanResource\RelationManagers;
use App\Models\PbkmKegiatanPemanduan;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Malzariey\FilamentDaterangepickerFilter\Filters\DateRangeFilter;
use Carbon\Carbon;
use Filament\Tables\Columns\ImageColumn;
use Filament\Tables\Columns\ViewColumn;

class PbkmKegiatanPemanduanResource extends Resource
{
    protected static ?string $model = PbkmKegiatanPemanduan::class;

    protected static ?string $navigationIcon = 'heroicon-o-circle-stack';

    protected static ?string $navigationGroup = 'Big Data';

    protected static ?string $navigationLabel = 'PBKM Kegiatan Pemanduan';

    protected static ?string $recordTitleAttribute = 'no_pkk';

    public static function getGloballySearchableAttributes(): array
    {
        return ['no_pkk', 'nama_agent', 'nama_dermaga_awal'];
    }

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\FileUpload::make('image_mulai')->image()->disk('minio')
                    ->imageEditor(),
                Forms\Components\FileUpload::make('image_sedang')->image()->disk('minio')
                    ->imageEditor(),
                Forms\Components\FileUpload::make('image_selesai')->image()->disk('minio')
                    ->imageEditor(),
                Forms\Components\FileUpload::make('image_mulai_2')->image()->disk('minio')
                    ->imageEditor(),
                Forms\Components\FileUpload::make('image_sedang_2')->image()->disk('minio')
                    ->imageEditor(),
                Forms\Components\FileUpload::make('image_selesai_2')->image()->disk('minio')
                    ->imageEditor(),
                Forms\Components\FileUpload::make('image_mulai_3')->image()->disk('minio')
                    ->imageEditor(),
                Forms\Components\FileUpload::make('image_sedang_3')->image()->disk('minio')
                    ->imageEditor(),
                Forms\Components\FileUpload::make('image_selesai_3')->image()->disk('minio')
                    ->imageEditor(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('nomor_spk_pandu')
                    ->searchable(),
                Tables\Columns\TextColumn::make('no_pkk')
                    ->searchable(),
                Tables\Columns\TextColumn::make('aisDataVessel.mmsi')
                    ->label('MMSI')
                    ->sortable(),
                Tables\Columns\TextColumn::make('tanggal_spk_pandu')
                    ->dateTime()
                    ->sortable(),
                Tables\Columns\TextColumn::make('nomor_imo')
                    ->searchable(),
                Tables\Columns\TextColumn::make('nomor_spog')
                    ->searchable(),
                Tables\Columns\TextColumn::make('npwp_agent')
                    ->searchable(),
                Tables\Columns\TextColumn::make('nama_agent')
                    ->searchable(),
                Tables\Columns\TextColumn::make('kode_dermaga_awal')
                    ->searchable(),
                Tables\Columns\TextColumn::make('nama_dermaga_awal')
                    ->searchable(),
                Tables\Columns\TextColumn::make('nama_dermaga_tujuan')
                    ->searchable(),
                Tables\Columns\TextColumn::make('no_pandu')
                    ->searchable(),
                // Tables\Columns\TextColumn::make('foto_di_kapal')
                //     ->searchable(),
                ImageColumn::make('foto_di_kapal')
                    ->getStateUsing(function (PbkmKegiatanPemanduan $record): string {
                        return $record->foto_di_kapal ?? '';
                    })
                    ->extraImgAttributes([
                        'img' => 'src'
                    ]),
                ImageColumn::make('bpjp')
                    ->getStateUsing(function (PbkmKegiatanPemanduan $record): string {
                        return $record->bpjp ?? '';
                    })
                    ->extraImgAttributes([
                        'img' => 'src'
                    ]),
                Tables\Columns\TextColumn::make('nama_pandu')
                    ->searchable(),
                Tables\Columns\TextColumn::make('nama_kapal')
                    ->searchable(),
                Tables\Columns\TextColumn::make('bendera_kapal')
                    ->searchable(),
                Tables\Columns\TextColumn::make('grt')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('dwt')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('loa')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('actual_mulai_bongkar')
                    ->dateTime()
                    ->sortable(),
                Tables\Columns\TextColumn::make('actual_mulai_muat')
                    ->dateTime()
                    ->sortable(),
                Tables\Columns\TextColumn::make('mmsi')->searchable()->sortable(),
                Tables\Columns\TextColumn::make('actual_selesai_bongkar')
                    ->dateTime()
                    ->sortable(),
                Tables\Columns\TextColumn::make('actual_selesai_muat')
                    ->dateTime()
                    ->sortable(),
                Tables\Columns\TextColumn::make('tanggal_pandu_naik_kapal')
                    ->date()
                    ->sortable(),
                Tables\Columns\TextColumn::make('tanggal_pandu_turun_kapal')
                    ->date()
                    ->sortable(),
                Tables\Columns\TextColumn::make('jam_pandu_naik_kapal'),
                Tables\Columns\TextColumn::make('jam_pandu_turun_kapal'),
                Tables\Columns\TextColumn::make('biaya_layanan')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('jumlah_pnbp')
                    ->numeric()
                    ->sortable(),
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
            'index' => Pages\ListPbkmKegiatanPemanduans::route('/'),
            'create' => Pages\CreatePbkmKegiatanPemanduan::route('/create'),
            'edit' => Pages\EditPbkmKegiatanPemanduan::route('/{record}/edit'),
        ];
    }
}
