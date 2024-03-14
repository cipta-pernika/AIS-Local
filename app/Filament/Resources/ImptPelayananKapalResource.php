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
use Filament\Tables\Actions\Action;
use Illuminate\Database\Eloquent\Model;
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
                Forms\Components\TextInput::make('no_pkk')
                    ->required()
                    ->maxLength(255),
                Forms\Components\TextInput::make('ais_data_vessel_id')
                    ->numeric(),
                Forms\Components\TextInput::make('nama_kapal')
                    ->maxLength(255),
                Forms\Components\TextInput::make('gt')
                    ->maxLength(255),
                Forms\Components\TextInput::make('nama_agen_pelayaran')
                    ->maxLength(255),
                Forms\Components\DateTimePicker::make('waktu_kedatangan'),
                Forms\Components\DateTimePicker::make('waktu_keberangkatan'),
                Forms\Components\TextInput::make('posisi')
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
                Tables\Columns\TextColumn::make('no_pkk')
                    ->searchable(),
                Tables\Columns\TextColumn::make('aisDataVessel.mmsi')
                    ->label('MMSI')
                    ->numeric()
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
                DateRangeFilter::make('created_at')->startDate(Carbon::now())->endDate(Carbon::now()),
            ])
            ->actions([
                Action::make('checkPosisi')
                    ->label('Cek Posisi')->url(fn (Model $record): string => route('cekposisi', ['record' => $record, 'source' => 'impt_pelayanan_kapal']))->openUrlInNewTab(),
                Action::make('playback')
                    ->label('Playback')->url(fn (Model $record): string => route('playback', ['record' => $record, 'source' => 'impt_pelayanan_kapal']))->openUrlInNewTab()
                // Tables\Actions\EditAction::make(),
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
