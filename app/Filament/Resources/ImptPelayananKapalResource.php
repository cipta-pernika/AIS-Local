<?php

namespace App\Filament\Resources;

use App\Filament\Resources\ImptPelayananKapalResource\Pages;
use App\Filament\Resources\ImptPelayananKapalResource\RelationManagers;
use App\Models\ImptPelayananKapal;
use Carbon\Carbon;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Malzariey\FilamentDaterangepickerFilter\Filters\DateRangeFilter;

class ImptPelayananKapalResource extends Resource
{
    protected static ?string $model = ImptPelayananKapal::class;

    protected static ?string $navigationIcon = 'heroicon-o-circle-stack';

    protected static ?string $navigationGroup = 'Big Data';

    protected static ?string $navigationLabel = 'IMPT Pelayanan Kapal';

    protected static ?string $recordTitleAttribute = 'no_pkk';

    public static function getGloballySearchableAttributes(): array
    {
        return ['no_pkk', 'nama_kapal', 'nama_agen_pelayaran'];
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
                Tables\Columns\TextColumn::make('no_pkk')
                    ->searchable(),
                Tables\Columns\TextColumn::make('aisDataVessel.mmsi')
                    ->label('MMSI')
                    ->sortable(),
                Tables\Columns\TextColumn::make('nama_kapal')
                    ->searchable(),
                Tables\Columns\TextColumn::make('mmsi')->searchable()->sortable(),
                Tables\Columns\TextColumn::make('gt')
                    ->searchable(),
                Tables\Columns\TextColumn::make('nama_agen_pelayaran')
                    ->searchable(),
                Tables\Columns\TextColumn::make('waktu_kedatangan')
                    ->dateTime()
                    ->sortable(),
                Tables\Columns\TextColumn::make('waktu_keberangkatan')
                    ->dateTime()
                    ->sortable(),
                Tables\Columns\TextColumn::make('posisi')
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
                DateRangeFilter::make('updated_at')->startDate(Carbon::now())->endDate(Carbon::now()),
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
            'index' => Pages\ListImptPelayananKapals::route('/'),
            'create' => Pages\CreateImptPelayananKapal::route('/create'),
            'edit' => Pages\EditImptPelayananKapal::route('/{record}/edit'),
        ];
    }
}
