<?php

namespace App\Filament\Resources;

use App\Filament\Resources\PbkmKegiatanPemanduanResource\Pages;
use App\Filament\Resources\PbkmKegiatanPemanduanResource\RelationManagers;
use App\Models\PbkmKegiatanPemanduan;
use Carbon\Carbon;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Filament\Tables\Actions\Action;
use Filament\Tables\Columns\ImageColumn;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Filament\Tables\Filters\QueryBuilder;
use Filament\Tables\Filters\QueryBuilder\Constraints\BooleanConstraint;
use Filament\Tables\Filters\QueryBuilder\Constraints\DateConstraint;
use Filament\Tables\Filters\QueryBuilder\Constraints\NumberConstraint;
use Filament\Tables\Filters\QueryBuilder\Constraints\RelationshipConstraint;
use Filament\Tables\Filters\QueryBuilder\Constraints\RelationshipConstraint\Operators\IsRelatedToOperator;
use Filament\Tables\Filters\QueryBuilder\Constraints\SelectConstraint;
use Filament\Tables\Filters\QueryBuilder\Constraints\TextConstraint;
use Malzariey\FilamentDaterangepickerFilter\Filters\DateRangeFilter;

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
                Forms\Components\TextInput::make('nomor_spk_pandu')
                    ->required()
                    ->maxLength(255),
                Forms\Components\TextInput::make('no_pkk')
                    ->required()
                    ->maxLength(255),
                Forms\Components\TextInput::make('ais_data_vessel_id')
                    ->numeric(),
                Forms\Components\DateTimePicker::make('tanggal_spk_pandu'),
                Forms\Components\TextInput::make('nomor_imo')
                    ->maxLength(255),
                Forms\Components\TextInput::make('nomor_spog')
                    ->maxLength(255),
                Forms\Components\TextInput::make('npwp_agent')
                    ->maxLength(255),
                Forms\Components\TextInput::make('nama_agent')
                    ->maxLength(255),
                Forms\Components\TextInput::make('kode_dermaga_awal')
                    ->maxLength(255),
                Forms\Components\TextInput::make('nama_dermaga_awal')
                    ->maxLength(255),
                Forms\Components\TextInput::make('nama_dermaga_tujuan')
                    ->maxLength(255),
                Forms\Components\TextInput::make('no_pandu')
                    ->maxLength(255),
                Forms\Components\TextInput::make('nama_pandu')
                    ->maxLength(255),
                Forms\Components\TextInput::make('nama_kapal')
                    ->maxLength(255),
                Forms\Components\TextInput::make('bendera_kapal')
                    ->maxLength(255),
                Forms\Components\TextInput::make('grt')
                    ->numeric(),
                Forms\Components\TextInput::make('dwt')
                    ->numeric(),
                Forms\Components\TextInput::make('loa')
                    ->numeric(),
                Forms\Components\DatePicker::make('tanggal_pandu_naik_kapal'),
                Forms\Components\DatePicker::make('tanggal_pandu_turun_kapal'),
                Forms\Components\TextInput::make('jam_pandu_naik_kapal'),
                Forms\Components\TextInput::make('jam_pandu_turun_kapal'),
                Forms\Components\TextInput::make('biaya_layanan')
                    ->numeric(),
                Forms\Components\TextInput::make('jumlah_pnbp')
                    ->numeric(),
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
                DateRangeFilter::make('updated_at')->startDate(Carbon::now()->subDays(7))->endDate(Carbon::now()),
                QueryBuilder::make()
                    ->constraints([
                        TextConstraint::make('nama_kapal'),
                        TextConstraint::make('nomor_spk_pandu'),
                        TextConstraint::make('no_pkk'),
                        TextConstraint::make('nomor_imo'),
                        TextConstraint::make('nomor_spog'),
                        TextConstraint::make('nama_agent'),
                        TextConstraint::make('nama_dermaga_tujuan'),
                        TextConstraint::make('nama_pandu'),
                        NumberConstraint::make('dwt'),
                    ])
            ])
            ->actions([
                Action::make('checkPosisi')
                    ->label('Cek Posisi')->url(fn (Model $record): string => route('cekposisi', ['record' => $record, 'source' => 'pbkm-kegiatan-pemanduan']))->openUrlInNewTab(),
                Action::make('playback')
                    ->label('Playback')->url(fn (Model $record): string => route('playback', ['record' => $record, 'source' => 'pbkm-kegiatan-pemanduan']))->openUrlInNewTab()
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
            'index' => Pages\ListPbkmKegiatanPemanduans::route('/'),
            'create' => Pages\CreatePbkmKegiatanPemanduan::route('/create'),
            'edit' => Pages\EditPbkmKegiatanPemanduan::route('/{record}/edit'),
        ];
    }
}
