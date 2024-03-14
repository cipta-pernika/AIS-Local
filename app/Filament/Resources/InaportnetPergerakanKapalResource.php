<?php

namespace App\Filament\Resources;

use App\Filament\Resources\InaportnetPergerakanKapalResource\Pages;
use App\Filament\Resources\InaportnetPergerakanKapalResource\RelationManagers;
use App\Models\AisDataVessel;
use Filament\Tables\Enums\ActionsPosition;
use App\Models\InaportnetPergerakanKapal;
use Carbon\Carbon;
use Malzariey\FilamentDaterangepickerFilter\Filters\DateRangeFilter;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Filament\Forms\Components\Select;
use Filament\Forms\Get;
use Filament\Tables\Actions\Action;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletingScope;

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
                Forms\Components\TextInput::make('no_pkk')
                    ->required()
                    ->maxLength(255),
                Forms\Components\TextInput::make('ais_data_vessel_id')
                    ->numeric(),
                Forms\Components\TextInput::make('nama_kapal')
                    ->maxLength(255),
                Forms\Components\TextInput::make('jenis_layanan')
                    ->maxLength(255),
                Forms\Components\TextInput::make('nama_negara')
                    ->maxLength(255),
                Forms\Components\TextInput::make('tipe_kapal')
                    ->maxLength(255),
                Forms\Components\TextInput::make('nama_perusahaan')
                    ->maxLength(255),
                Forms\Components\TextInput::make('tgl_tiba')
                    ->maxLength(255),
                Forms\Components\TextInput::make('tgl_brangkat')
                    ->maxLength(255),
                Forms\Components\TextInput::make('bendera')
                    ->maxLength(255),
                Forms\Components\TextInput::make('gt_kapal')
                    ->numeric(),
                Forms\Components\TextInput::make('dwt')
                    ->numeric(),
                Forms\Components\TextInput::make('no_imo')
                    ->maxLength(255),
                Forms\Components\TextInput::make('call_sign')
                    ->maxLength(255),
                Forms\Components\TextInput::make('nakhoda')
                    ->maxLength(255),
                Forms\Components\TextInput::make('jenis_trayek')
                    ->maxLength(255),
                Forms\Components\TextInput::make('pelabuhan_asal')
                    ->maxLength(255),
                Forms\Components\TextInput::make('pelabuhan_tujuan')
                    ->maxLength(255),
                Forms\Components\TextInput::make('lokasi_lambat_labuh')
                    ->maxLength(255),
                Forms\Components\TextInput::make('waktu_respon')
                    ->maxLength(255),
                Forms\Components\TextInput::make('nomor_spog')
                    ->maxLength(255),
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
                DateRangeFilter::make('created_at')->startDate(Carbon::now())->endDate(Carbon::now()),
                Tables\Filters\SelectFilter::make('tipe_kapal')
                    ->options([
                        'TONGKANG / BARGE' => 'TONGKANG / BARGE',
                        'KAPAL MOTOR TUNDA (TUG BOAT)' => 'KAPAL MOTOR TUNDA (TUG BOAT)'
                    ]),
            ])
            ->filtersTriggerAction(
                fn (Action $action) => $action
                    ->button()
                    ->label('Filter'),
            )
            ->actions([
                Action::make('checkPosisi')
                    ->label('Cek Posisi')->url(fn (Model $record): string => route('cekposisi', ['record' => $record, 'source' => 'inaportnet-pergerakan-kapal']))->openUrlInNewTab(),
                Action::make('playback')
                    ->label('Playback')->url(fn (Model $record): string => route('playback', ['record' => $record, 'source' => 'inaportnet-pergerakan-kapal']))->openUrlInNewTab()
                // Tables\Actions\EditAction::make(),
                // Action::make('assign')->icon('heroicon-m-pencil-square')
                //     ->button()
                //     // ->hidden($record->no_pkk_assign !== null)
                //     // ->hidden(function (array $data) {
                //     //     return isset($data['no_pkk_assign']) && $data['no_pkk_assign'] !== null;
                //     // })
                //     // ->hidden(fn (Get $get): bool => $get('no_pkk_assign') !== null)
                //     // ->hidden(function () use ($assignId) {
                //     //     return $assignId !== null;
                //     // })
                //     ->hidden(function (Table $table, Model $record) {
                //         // Check if no_pkk_assign is not null
                //         if ($record->no_pkk_assign !== null) {
                //             return true; // Hide the action
                //         }

                //         if ($record->tipe_kapal !== 'TONGKANG / BARGE') {
                //             return true; // Hide the action
                //         }

                //         return false; // Show the action
                //     })
                //     // ->badge(5)
                //     ->badgeColor('success')
                //     ->label('Assign')
                //     ->labeledFrom('md')
                //     ->form([
                //         // Select::make('no_pkk_assign')
                //         //     ->label('No PKK')
                //         //     ->native(false)
                //         //     ->searchable()
                //         //     ->relationship(
                //         //         name: 'assignId',
                //         //         modifyQueryUsing: fn (Builder $query) => $query->orderBy('no_pkk')->orderBy('vessel_name')->whereNotNull('no_pkk'),
                //         //     )
                //         //     // ->options(AisDataVessel::query()->whereNotNull('no_pkk')->pluck('no_pkk', 'no_pkk'))
                //         //     // ->getSearchResultsUsing(fn (string $search): array => AisDataVessel::where('no_pkk', 'like', "%{$search}%")
                //         //     //     ->whereNotNull('no_pkk')
                //         //     //     ->limit(50)->pluck('no_pkk', 'no_pkk')->toArray())
                //         //     // ->getOptionLabelUsing(fn ($value): ?string => AisDataVessel::find($value)?->name)
                //         //     ->getOptionLabelFromRecordUsing(fn (Model $record) => "{$record->no_pkk} {$record->vessel_name}")
                //         //     ->required(),
                //         Select::make('assignId')
                //             ->label('No PKK')
                //             ->required()
                //             ->relationship(
                //                 name: 'assignId',
                //                 modifyQueryUsing: fn (Builder $query) => $query->orderBy('no_pkk')->orderBy('vessel_name'),
                //             )
                //             ->getOptionLabelFromRecordUsing(fn (Model $record) => "{$record->no_pkk} ~ {$record->vessel_name} ~ {$record->nama_perusahaan}")
                //             ->searchable(['no_pkk', 'vessel_name', 'nama_perusahaan'])
                //     ])
                //     ->action(function (array $data, InaportnetPergerakanKapal $record): void {
                //         $record->no_pkk_assign = $data['no_pkk_assign'];
                //         $record->update();
                //     })
                //     ->fillForm(fn (InaportnetPergerakanKapal $record): array => [
                //         'no_pkk_assign' => $record->no_pkk_assign,
                //     ])
            ], position: ActionsPosition::BeforeColumns)
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
