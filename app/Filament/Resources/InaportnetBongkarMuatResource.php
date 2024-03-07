<?php

namespace App\Filament\Resources;

use App\Filament\Resources\InaportnetBongkarMuatResource\Pages;
use App\Filament\Resources\InaportnetBongkarMuatResource\RelationManagers;
use App\Models\InaportnetBongkarMuat;
use Carbon\Carbon;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Enums\ActionsPosition;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Filament\Tables\Columns\Layout\Split;
use Filament\Tables\Columns\ViewColumn;
use Filament\Tables\Actions\Action;
use Illuminate\Database\Eloquent\Model;
use Malzariey\FilamentDaterangepickerFilter\Filters\DateRangeFilter;
use Filament\Tables\Filters\QueryBuilder;
use Filament\Tables\Filters\QueryBuilder\Constraints\BooleanConstraint;
use Filament\Tables\Filters\QueryBuilder\Constraints\DateConstraint;
use Filament\Tables\Filters\QueryBuilder\Constraints\NumberConstraint;
use Filament\Tables\Filters\QueryBuilder\Constraints\RelationshipConstraint;
use Filament\Tables\Filters\QueryBuilder\Constraints\RelationshipConstraint\Operators\IsRelatedToOperator;
use Filament\Tables\Filters\QueryBuilder\Constraints\SelectConstraint;
use Filament\Tables\Filters\QueryBuilder\Constraints\TextConstraint;

class InaportnetBongkarMuatResource extends Resource
{
    protected static ?string $model = InaportnetBongkarMuat::class;

    protected static ?string $navigationIcon = 'heroicon-o-circle-stack';

    protected static ?string $navigationGroup = 'Big Data';

    protected static ?string $navigationLabel = 'INAPORTNET Bongkar Muat';

    protected static ?string $recordTitleAttribute = 'no_pkk';

    public static function getGloballySearchableAttributes(): array
    {
        return ['no_pkk', 'nama_kapal', 'nama_perusahaan'];
    }

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('no_pkk')
                    ->maxLength(255),
                Forms\Components\TextInput::make('pbm_kode')
                    ->maxLength(255),
                Forms\Components\TextInput::make('id_rkbm')
                    ->required()
                    ->numeric(),
                Forms\Components\TextInput::make('no_surat_keluar')
                    ->maxLength(255),
                Forms\Components\TextInput::make('kade')
                    ->maxLength(255),
                Forms\Components\DatePicker::make('rencana_bongkar'),
                Forms\Components\DatePicker::make('rencana_muat'),
                Forms\Components\DatePicker::make('mulai_bongkar'),
                Forms\Components\DatePicker::make('mulai_muat'),
                Forms\Components\DatePicker::make('selesai_bongkar'),
                Forms\Components\DatePicker::make('selesai_muat'),
                Forms\Components\TextInput::make('nomor_layanan_masuk')
                    ->maxLength(255),
                Forms\Components\TextInput::make('nomor_layanan_sps')
                    ->maxLength(255),
                Forms\Components\TextInput::make('nama_kapal')
                    ->maxLength(255),
                Forms\Components\TextInput::make('gt_kapal')
                    ->numeric(),
                Forms\Components\TextInput::make('panjang_kapal')
                    ->numeric(),
                Forms\Components\TextInput::make('dwt')
                    ->numeric(),
                Forms\Components\TextInput::make('siupal_pemilik')
                    ->maxLength(255),
                Forms\Components\TextInput::make('siupal_operator')
                    ->maxLength(255),
                Forms\Components\TextInput::make('bendera')
                    ->maxLength(255),
                Forms\Components\TextInput::make('nama_perusahaan')
                    ->maxLength(255),
                Forms\Components\TextInput::make('nomor_produk')
                    ->maxLength(255),
                Forms\Components\TextInput::make('tipe_kapal')
                    ->maxLength(255),
                Forms\Components\TextInput::make('pbm')
                    ->maxLength(255),
                Forms\Components\Textarea::make('bongkar')
                    ->columnSpanFull(),
                Forms\Components\Textarea::make('muat')
                    ->columnSpanFull(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                // Split::make([
                // Tables\Columns\TextColumn::make('no_pkk')
                //     ->searchable(),
                // Tables\Columns\TextColumn::make('pbm_kode')
                //     ->searchable(),
                // Tables\Columns\TextColumn::make('id_rkbm')
                //     ->numeric()
                //     ->sortable(),
                // ])->from('xl'),
                ViewColumn::make('id_rkbm')
                    ->view('filament.tables.columns.no-rkbm')
                    ->label('Nomor PKK'),
                ViewColumn::make('tipe_kapal')
                    ->view('filament.tables.columns.nama-kapal')
                    ->label('Nama Kapal'),
                ViewColumn::make('nama_perusahaan')
                    ->view('filament.tables.columns.nama-perusahaan')
                    ->label('Nama Perusahaan'),
                ViewColumn::make('mulai_bongkar')
                    ->view('filament.tables.columns.mulai-bongkar')
                    ->label('Jadwal Bongkar'),
                ViewColumn::make('image_mulai')
                    ->view('filament.tables.columns.cctv')
                    ->label('Mulai Bongkar/Muat'),
                ViewColumn::make('image_sedang')
                    ->view('filament.tables.columns.cctvsedang')
                    ->label('Sedang Bongkar/Muat'),
                ViewColumn::make('image_selesai')
                    ->view('filament.tables.columns.cctvakhir')
                    ->label('Selesai Bongkar/Muat'),
                Tables\Columns\TextColumn::make('nama_kapal')
                    ->searchable()->toggleable(),
                Tables\Columns\TextColumn::make('no_pkk')
                    ->searchable()->toggleable(),
                // Tables\Columns\TextColumn::make('no_surat_keluar')
                //     ->searchable(),
                // Tables\Columns\TextColumn::make('kade')
                //     ->searchable(),
                // Tables\Columns\TextColumn::make('rencana_bongkar')
                //     ->date()
                //     ->sortable(),
                // Tables\Columns\TextColumn::make('rencana_muat')
                //     ->date()
                //     ->sortable(),
                // Tables\Columns\TextColumn::make('mulai_bongkar')
                //     ->date()
                //     ->sortable(),
                // Tables\Columns\TextColumn::make('mulai_muat')
                //     ->date()
                //     ->sortable(),
                // Tables\Columns\TextColumn::make('selesai_bongkar')
                //     ->date()
                //     ->sortable(),
                // Tables\Columns\TextColumn::make('selesai_muat')
                //     ->date()
                //     ->sortable(),
                // Tables\Columns\TextColumn::make('nomor_layanan_masuk')
                //     ->searchable(),
                // Tables\Columns\TextColumn::make('nomor_layanan_sps')
                //     ->searchable(),
                // Tables\Columns\TextColumn::make('aisDataVessel.mmsi')
                //     ->label('MMSI')
                //     ->numeric()
                //     ->sortable(),
                // Tables\Columns\TextColumn::make('nama_kapal')
                //     ->searchable(),
                // Tables\Columns\TextColumn::make('gt_kapal')
                //     ->numeric()
                //     ->sortable(),
                // Tables\Columns\TextColumn::make('panjang_kapal')
                //     ->numeric()
                //     ->sortable(),
                // Tables\Columns\TextColumn::make('dwt')
                //     ->numeric()
                //     ->sortable(),
                // Tables\Columns\TextColumn::make('siupal_pemilik')
                //     ->searchable(),
                // Tables\Columns\TextColumn::make('siupal_operator')
                //     ->searchable(),
                // Tables\Columns\TextColumn::make('bendera')
                //     ->searchable(),
                // Tables\Columns\TextColumn::make('nama_perusahaan')
                //     ->searchable(),
                // Tables\Columns\TextColumn::make('nomor_produk')
                //     ->searchable(),
                // Tables\Columns\TextColumn::make('tipe_kapal')
                //     ->searchable(),
                // Tables\Columns\TextColumn::make('pbm')
                //     ->searchable(),
                // Tables\Columns\TextColumn::make('created_at')
                //     ->dateTime()
                //     ->sortable()
                //     ->toggleable(isToggledHiddenByDefault: true),
                // Tables\Columns\TextColumn::make('updated_at')
                //     ->dateTime()
                //     ->sortable()
                //     ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                DateRangeFilter::make('created_at')->startDate(Carbon::now())->endDate(Carbon::now()),
                QueryBuilder::make()
                    ->constraints([
                        TextConstraint::make('nama_kapal'),
                    ])
            ])
            ->filtersFormColumns(2)
            ->filtersTriggerAction(
                fn (Action $action) => $action
                    ->button()
                    ->label('Filter'),
            )
            ->actions([
                // Tables\Actions\EditAction::make(),
                Action::make('checkPosisi')
                    ->label('Cek Posisi')->url(fn (Model $record): string => route('cekposisi', ['record' => $record]))->openUrlInNewTab(),
                Action::make('playback')
                    ->label('Playback')->url(fn (Model $record): string => route('playback', ['record' => $record]))->openUrlInNewTab()
            ], position: ActionsPosition::BeforeColumns)
            ->bulkActions([
                // Tables\Actions\BulkActionGroup::make([
                //     Tables\Actions\DeleteBulkAction::make(),
                // ]),
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
            'index' => Pages\ListInaportnetBongkarMuats::route('/'),
            'create' => Pages\CreateInaportnetBongkarMuat::route('/create'),
            'edit' => Pages\EditInaportnetBongkarMuat::route('/{record}/edit'),
        ];
    }
}
