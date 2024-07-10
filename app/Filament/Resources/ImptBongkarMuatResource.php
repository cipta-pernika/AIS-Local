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
use Malzariey\FilamentDaterangepickerFilter\Filters\DateRangeFilter;
use Carbon\Carbon;
use Filament\Tables\Columns\ViewColumn;

class ImptBongkarMuatResource extends Resource
{
    protected static ?string $model = ImptBongkarMuat::class;

    protected static ?string $navigationIcon = 'heroicon-o-circle-stack';

    protected static ?string $navigationGroup = 'Big Data';

    protected static ?string $navigationLabel = 'IMPT Bongkar Muat';

    protected static ?string $recordTitleAttribute = 'no_pkk';

    /**
     * Get the navigation badge for the resource.
     */
    public static function getNavigationBadge(): ?string
    {
        return number_format(static::getModel()::count());
    }

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\FileUpload::make('image_mulai')->image()->disk('public')
                    ->imageEditor(),
                Forms\Components\FileUpload::make('image_sedang')->image()->disk('public')
                    ->imageEditor(),
                Forms\Components\FileUpload::make('image_selesai')->image()->disk('public')
                    ->imageEditor(),
                Forms\Components\FileUpload::make('image_mulai_2')->image()->disk('public')
                    ->imageEditor(),
                Forms\Components\FileUpload::make('image_sedang_2')->image()->disk('public')
                    ->imageEditor(),
                Forms\Components\FileUpload::make('image_selesai_2')->image()->disk('public')
                    ->imageEditor(),
                Forms\Components\FileUpload::make('image_mulai_3')->image()->disk('public')
                    ->imageEditor(),
                Forms\Components\FileUpload::make('image_sedang_3')->image()->disk('public')
                    ->imageEditor(),
                Forms\Components\FileUpload::make('image_selesai_3')->image()->disk('public')
                    ->imageEditor(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('mmsi')->searchable(),
                // Tables\Columns\TextColumn::make('rkbm')->searchable(),
                ViewColumn::make('id_rkbm')
                    ->view('filament.tables.columns.no-rkbm')
                    ->label('Nomor PKK'),
                // Tables\Columns\TextColumn::make('ais_data_vessel_id')->searchable(),
                Tables\Columns\TextColumn::make('nomor_registrasi_cargo')->searchable(),
                ViewColumn::make('nama_perusahaan')
                    ->view('filament.tables.columns.nama-perusahaan')
                    ->label('Nama Perusahaan'),
                ViewColumn::make('pemilik_barang')
                    ->view('filament.tables.columns.pemilik-barang')
                    ->label('Pemilik Barang'),
                Tables\Columns\TextColumn::make('jenis')->searchable(),
                Tables\Columns\TextColumn::make('jumlah_tonase')->searchable(),
                Tables\Columns\TextColumn::make('jumlah_biaya')->searchable(),
                Tables\Columns\TextColumn::make('jumlah_pnbp')->searchable(),
                Tables\Columns\TextColumn::make('kegiatan')->searchable(),
                Tables\Columns\TextColumn::make('tanggal_mulai')->searchable(),
                Tables\Columns\TextColumn::make('tanggal_selesai')->searchable(),
                Tables\Columns\TextColumn::make('date')->searchable(),
                
                ViewColumn::make('image_mulai')
                    ->view('filament.tables.columns.image-column')
                    ->label('Mulai Bongkar/Muat'),
                ViewColumn::make('image_sedang')
                    ->view('filament.tables.columns.image-column-sedang')
                    ->label('Sedang Bongkar/Muat'),
                ViewColumn::make('image_selesai')
                    ->view('filament.tables.columns.image-column-akhir')
                    ->label('Selesai Bongkar/Muat'),
                Tables\Columns\TextColumn::make('no_pkk_assign')->searchable(),
                Tables\Columns\TextColumn::make('no_pkk')->searchable(),
                ViewColumn::make('nama_kapal')
                    ->view('filament.tables.columns.nama-kapal')
                    ->label('Nama Kapal'),
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
