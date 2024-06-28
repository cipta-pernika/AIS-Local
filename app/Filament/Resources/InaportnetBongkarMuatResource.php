<?php

namespace App\Filament\Resources;

use App\Filament\Resources\InaportnetBongkarMuatResource\Pages;
use App\Filament\Resources\InaportnetBongkarMuatResource\RelationManagers;
use App\Models\InaportnetBongkarMuat;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Malzariey\FilamentDaterangepickerFilter\Filters\DateRangeFilter;
use Filament\Tables\Filters\QueryBuilder;
use Filament\Tables\Filters\QueryBuilder\Constraints\BooleanConstraint;
use Filament\Tables\Filters\QueryBuilder\Constraints\DateConstraint;
use Filament\Tables\Filters\QueryBuilder\Constraints\NumberConstraint;
use Filament\Tables\Filters\QueryBuilder\Constraints\RelationshipConstraint;
use Filament\Tables\Filters\QueryBuilder\Constraints\RelationshipConstraint\Operators\IsRelatedToOperator;
use Filament\Tables\Filters\QueryBuilder\Constraints\SelectConstraint;
use Filament\Tables\Filters\QueryBuilder\Constraints\TextConstraint;
use Carbon\Carbon;
use Filament\Tables\Columns\ViewColumn;

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
                Tables\Columns\TextColumn::make('mmsi')->searchable()->sortable(),
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
            ])
            ->filters([
                DateRangeFilter::make('updated_at')->startDate(Carbon::now())->endDate(Carbon::now()),
                QueryBuilder::make()
                    ->constraints([
                        TextConstraint::make('nama_kapal'),
                    ])
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
            'index' => Pages\ListInaportnetBongkarMuats::route('/'),
            'create' => Pages\CreateInaportnetBongkarMuat::route('/create'),
            'edit' => Pages\EditInaportnetBongkarMuat::route('/{record}/edit'),
        ];
    }
}
