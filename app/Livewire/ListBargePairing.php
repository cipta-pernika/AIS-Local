<?php

namespace App\Livewire;

use App\Models\AisDataVessel;
use App\Models\InaportnetBongkarMuat;
use App\Models\InaportnetPergerakanKapal;
use App\Models\PkkAssignHistory;
use App\Models\PkkHistory;
use Carbon\Carbon;
use Livewire\Component;
use Filament\Forms\Concerns\InteractsWithForms;
use Filament\Forms\Contracts\HasForms;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Concerns\InteractsWithTable;
use Filament\Tables\Enums\ActionsPosition;
use Filament\Tables\Contracts\HasTable;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Filament\Tables\Actions\Action;
use Filament\Forms\Components\Select;
use Illuminate\Database\Eloquent\Model;
use Filament\Tables\Filters\SelectFilter;
use Illuminate\Contracts\View\View;

class ListBargePairing extends Component implements HasForms, HasTable
{
    use InteractsWithTable;
    use InteractsWithForms;

    public function table(Table $table): Table
    {
        return $table
            ->query(InaportnetBongkarMuat::query()->whereIn('tipe_kapal',  ['TONGKANG / BARGE', 'TONGKANG GELADAK (DECK BARGE)', 'TONGKANG MINYAK (OIL BARGE)', 'TONGKANG KERJA (WORK BARGE)', 'VEGETABLE OIL BARGE / TONGKANG MINYAK NABATI'])
                ->whereNull('no_pkk_assign')
                ->whereDate('updated_at', Carbon::today()))
            ->columns([
                TextColumn::make('no_pkk'),
                TextColumn::make('aisDataVessel.mmsi')
                    ->label('MMSI')
                    ->numeric()
                    ->sortable(),
                TextColumn::make('nama_kapal')
                    ->searchable(),
                TextColumn::make('jenis_layanan'),
                TextColumn::make('nama_negara'),
                TextColumn::make('tipe_kapal')->action(
                    Action::make('assign')->icon('heroicon-m-pencil-square')
                        ->button()
                        ->badgeColor('success')
                        ->label('Assign')
                        ->labeledFrom('md')
                        ->form([
                            Select::make('no_pkk_assign')
                                ->label('No PKK')
                                ->options(AisDataVessel::query()->whereNotNull('no_pkk')->pluck('no_pkk', 'no_pkk'))
                                ->required(),
                        ])
                        ->action(function (array $data, InaportnetBongkarMuat $record): void {
                            $record->no_pkk_assign = $data['no_pkk_assign'];
                            $record->update();
                        })
                ),
                TextColumn::make('nama_perusahaan'),
                TextColumn::make('tgl_tiba'),
                TextColumn::make('tgl_brangkat'),
                TextColumn::make('bendera'),
                TextColumn::make('gt_kapal')
                    ->numeric()
                    ->sortable(),
                TextColumn::make('dwt')
                    ->numeric()
                    ->sortable(),
                TextColumn::make('no_imo'),
                TextColumn::make('call_sign'),
                TextColumn::make('nakhoda'),
                TextColumn::make('jenis_trayek'),
                TextColumn::make('pelabuhan_asal'),
                TextColumn::make('pelabuhan_tujuan'),
                TextColumn::make('lokasi_lambat_labuh'),
                TextColumn::make('waktu_respon'),
                TextColumn::make('nomor_spog'),
            ])
            ->filters([
                // SelectFilter::make('tipe_kapal')
                //     ->options([
                //         'TONGKANG / BARGE' => 'TONGKANG / BARGE',
                //         'KAPAL MOTOR TUNDA (TUG BOAT)' => 'KAPAL MOTOR TUNDA (TUG BOAT)'
                //     ]),
            ])
            ->filtersTriggerAction(
                fn (Action $action) => $action
                    ->button()
                    ->label('Filter'),
            )
            ->actions([
                Action::make('assign')->icon('heroicon-m-pencil-square')
                    ->button()
                    ->hidden(function (Table $table, Model $record) {
                        if ($record->no_pkk_assign !== null) {
                            return true; // Hide the action
                        }

                        if (!in_array($record->tipe_kapal, ['TONGKANG / BARGE', 'TONGKANG GELADAK (DECK BARGE)', 'TONGKANG MINYAK (OIL BARGE)', 'TONGKANG KERJA (WORK BARGE)', 'VEGETABLE OIL BARGE / TONGKANG MINYAK NABATI'])) {
                            return true; // Hide the action
                        }

                        return false; // Show the action
                    })
                    ->badgeColor('success')
                    ->label('Assign')
                    ->labeledFrom('md')
                    ->form([
                        // Select::make('assignId')
                        //     ->label('No PKK')
                        //     ->required()
                        //     ->relationship(
                        //         name: 'assignId',
                        //         modifyQueryUsing: fn (Builder $query) => $query->orderBy('no_pkk')->orderBy('vessel_name'),
                        //     )
                        //     ->getOptionLabelFromRecordUsing(fn (Model $record) => "{$record->no_pkk} ~ {$record->vessel_name} ~ {$record->nama_perusahaan}")
                        //     ->searchable(['no_pkk', 'vessel_name', 'nama_perusahaan'])
                        Select::make('no_pkk_assign')
                            ->label('No PKK')
                            ->native(false)
                            // ->relationship(
                            //     name: 'assignId',
                            //     modifyQueryUsing: fn (Builder $query) => $query->orderBy('no_pkk')->orderBy('vessel_name')->where('isAssign', 0),
                            // )
                            ->searchable(['no_pkk', 'vessel_name', 'nama_perusahaan'])
                            ->options(PkkHistory::query()->with('aisDataVessel')->where('isAssign', 0)->get()
                                ->map(function ($record) {
                                    return [
                                        'value' => $record->no_pkk,
                                        'label' => "{$record->no_pkk} ~ {$record->aisDataVessel->vessel_name} ~ {$record->aisDataVessel->nama_perusahaan}"
                                    ];
                                })
                                ->pluck('label', 'value'))
                            // ->getSearchResultsUsing(fn (string $search): array => AisDataVessel::where('no_pkk', 'like', "%{$search}%")
                            //     ->whereNotNull('no_pkk')
                            //     ->limit(50)->pluck('no_pkk', 'no_pkk')->toArray())
                            // ->getOptionLabelUsing(fn ($value): ?string => AisDataVessel::find($value)?->name)
                            // ->getOptionLabelFromRecordUsing(fn (Model $record) => "{$record->no_pkk} ~ {$record->vessel_name} ~ {$record->nama_perusahaan}")
                            ->required(),
                    ])
                    ->action(function (array $data, InaportnetBongkarMuat $record): void {
                        $record->no_pkk_assign = $data['no_pkk_assign'];

                        $aisDataVessel = AisDataVessel::whereNotNull('no_pkk')->where('isAssign', 0)->where('no_pkk', $data['no_pkk_assign'])->first();
                        $aisDataVessel->isAssign = 1;
                        $aisDataVessel->update();


                        $record->ais_data_vessel_id = $aisDataVessel->id;
                        $record->update();

                        $pkk_assign_history = new PkkAssignHistory;
                        $pkk_assign_history->ais_data_vessel_id = $aisDataVessel->id;
                        $pkk_assign_history->no_pkk_assign = $record->no_pkk_assign;
                        $pkk_assign_history->nama_perusahaan = $record->nama_perusahaan;
                        $pkk_assign_history->tanggal_acuan = $record->tanggal_acuan;
                        $pkk_assign_history->no_pkk = $record->no_pkk;
                        $pkk_assign_history->save();

                        $pkkhistory = PkkHistory::where('no_pkk', $data['no_pkk_assign'])->first();
                        $pkkhistory->isAssign = 1;
                        $pkkhistory->update();

                    })
                    ->fillForm(fn (InaportnetBongkarMuat $record): array => [
                        'no_pkk_assign' => $record->no_pkk_assign,
                    ])
            ], position: ActionsPosition::BeforeColumns)
            ->bulkActions([
                // ...
            ]);
    }

    public function render(): View
    {
        return view('livewire.list-barge-pairing');
    }
}
