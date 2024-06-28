<?php

namespace App\Filament\Resources;

use App\Filament\Resources\InaportnetPergerakanKapalResource\Pages;
use App\Filament\Resources\InaportnetPergerakanKapalResource\RelationManagers;
use App\Models\InaportnetPergerakanKapal;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Malzariey\FilamentDaterangepickerFilter\Filters\DateRangeFilter;
use Carbon\Carbon;

class InaportnetPergerakanKapalResource extends Resource
{
    protected static ?string $model = InaportnetPergerakanKapal::class;

    protected static ?string $navigationIcon = 'heroicon-o-circle-stack';

    protected static ?string $navigationGroup = 'Big Data';

    protected static ?string $navigationLabel = 'INAPORTNET Pergerakan Kapal';

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
                Tables\Columns\TextColumn::make('no_pkk')
                    ->searchable(),
                Tables\Columns\TextColumn::make('aisDataVessel.mmsi')
                    ->label('MMSI')
                    ->sortable(),
                Tables\Columns\TextColumn::make('nama_kapal')
                    ->searchable(),
                Tables\Columns\TextColumn::make('jenis_layanan')
                    ->searchable(),
                Tables\Columns\TextColumn::make('nama_negara')
                    ->searchable(),
                Tables\Columns\TextColumn::make('tipe_kapal')
                    ->searchable(),
                // ->action(
                //     Action::make('assign')->icon('heroicon-m-pencil-square')
                //         ->button()
                //         // ->hidden(!auth()->user()->can('update', $this->post))
                //         // ->badge(5)
                //         ->badgeColor('success')
                //         ->label('Assign')
                //         ->labeledFrom('md')
                //         ->form([
                //             Select::make('no_pkk_assign')
                //                 ->label('No PKK')
                //                 ->options(AisDataVessel::query()->whereNotNull('no_pkk')->pluck('no_pkk', 'no_pkk'))
                //                 ->required(),
                //         ])
                //         ->action(function (array $data, InaportnetPergerakanKapal $record): void {
                //             $record->no_pkk_assign = $data['no_pkk_assign'];
                //             $record->update();
                //         })
                // ),
                Tables\Columns\TextColumn::make('nama_perusahaan')
                    ->searchable(),
                Tables\Columns\TextColumn::make('tgl_tiba')
                    ->searchable(),
                Tables\Columns\TextColumn::make('tgl_brangkat')
                    ->searchable(),
                Tables\Columns\TextColumn::make('bendera')
                    ->searchable(),
                Tables\Columns\TextColumn::make('gt_kapal')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('dwt')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('no_imo')
                    ->searchable(),
                Tables\Columns\TextColumn::make('call_sign')
                    ->searchable(),
                Tables\Columns\TextColumn::make('nakhoda')
                    ->searchable(),
                Tables\Columns\TextColumn::make('jenis_trayek')
                    ->searchable(),
                Tables\Columns\TextColumn::make('pelabuhan_asal')
                    ->searchable(),
                Tables\Columns\TextColumn::make('pelabuhan_tujuan')
                    ->searchable(),
                Tables\Columns\TextColumn::make('lokasi_lambat_labuh')
                    ->searchable(),
                Tables\Columns\TextColumn::make('waktu_respon')
                    ->searchable(),
                Tables\Columns\TextColumn::make('nomor_spog')
                    ->searchable(),
                Tables\Columns\TextColumn::make('mmsi')->searchable()->sortable(),
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
            'index' => Pages\ListInaportnetPergerakanKapals::route('/'),
            'create' => Pages\CreateInaportnetPergerakanKapal::route('/create'),
            'edit' => Pages\EditInaportnetPergerakanKapal::route('/{record}/edit'),
        ];
    }
}
