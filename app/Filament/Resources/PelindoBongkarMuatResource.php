<?php

namespace App\Filament\Resources;

use App\Filament\Resources\PelindoBongkarMuatResource\Pages;
use App\Filament\Resources\PelindoBongkarMuatResource\RelationManagers;
use App\Models\PelindoBongkarMuat;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Malzariey\FilamentDaterangepickerFilter\Filters\DateRangeFilter;
use Carbon\Carbon;

class PelindoBongkarMuatResource extends Resource
{
    protected static ?string $model = PelindoBongkarMuat::class;

    protected static ?string $navigationIcon = 'heroicon-o-circle-stack';

    protected static ?string $navigationGroup = 'Big Data';

    protected static ?string $navigationLabel = 'Pelindo Bongkar Muat';

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
                Tables\Columns\TextColumn::make('ais_data_vessel_id')->searchable(),
                Tables\Columns\TextColumn::make('nama_kapal')->searchable(),
                Tables\Columns\TextColumn::make('nama_agent')->searchable(),
                Tables\Columns\TextColumn::make('ppk')->searchable(),
                Tables\Columns\TextColumn::make('gt_kapal')->searchable(),
                Tables\Columns\TextColumn::make('dwt')->searchable(),
                Tables\Columns\TextColumn::make('loa')->searchable(),
                Tables\Columns\TextColumn::make('nama_dermaga')->searchable(),
                Tables\Columns\TextColumn::make('rea_mulai_bm')->searchable(),
                Tables\Columns\TextColumn::make('rea_selesai_bm')->searchable(),
                Tables\Columns\TextColumn::make('jumlah_biaya')->searchable(),
                Tables\Columns\TextColumn::make('jumlah_pnbp')->searchable(),
                Tables\Columns\TextColumn::make('id_rkbm')->searchable(),
                Tables\Columns\TextColumn::make('pbm')->searchable(),
                Tables\Columns\TextColumn::make('kegiatan_bongkar_muat')->searchable(),
                Tables\Columns\TextColumn::make('jenis_barang')->searchable(),
                Tables\Columns\TextColumn::make('jumlah_barang')->searchable(),
                Tables\Columns\TextColumn::make('rea_mulai_tambat')->searchable(),
                Tables\Columns\TextColumn::make('rea_selesai_tambat')->searchable(),
                Tables\Columns\TextColumn::make('created_at_pelindo')->searchable(),
                Tables\Columns\TextColumn::make('image_mulai')->searchable(),
                Tables\Columns\TextColumn::make('image_sedang')->searchable(),
                Tables\Columns\TextColumn::make('image_selesai')->searchable(),
                Tables\Columns\TextColumn::make('image_mulai_2')->searchable(),
                Tables\Columns\TextColumn::make('image_sedang_2')->searchable(),
                Tables\Columns\TextColumn::make('image_selesai_2')->searchable(),
                Tables\Columns\TextColumn::make('image_mulai_3')->searchable(),
                Tables\Columns\TextColumn::make('image_sedang_3')->searchable(),
                Tables\Columns\TextColumn::make('image_selesai_3')->searchable(),
                Tables\Columns\TextColumn::make('no_pkk_assign')->searchable(),
                Tables\Columns\TextColumn::make('mmsi')->searchable(),
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
            'index' => Pages\ListPelindoBongkarMuats::route('/'),
            'create' => Pages\CreatePelindoBongkarMuat::route('/create'),
            'edit' => Pages\EditPelindoBongkarMuat::route('/{record}/edit'),
        ];
    }
}
