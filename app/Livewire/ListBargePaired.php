<?php

namespace App\Livewire;

use App\Models\AisDataVessel;
use App\Models\InaportnetBongkarMuat;
use App\Models\InaportnetPergerakanKapal;
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

class ListBargePaired extends Component implements HasForms, HasTable
{
    use InteractsWithTable;
    use InteractsWithForms;
    
    public function table(Table $table): Table
    {
        return $table
            ->query(InaportnetBongkarMuat::query()->where('tipe_kapal', 'TONGKANG / BARGE')->whereNotNull('no_pkk_assign'))
            ->columns([
                TextColumn::make('no_pkk'),
                TextColumn::make('no_pkk_assign'),
                TextColumn::make('aisDataVessel.mmsi')
                    ->label('MMSI')
                    ->numeric()
                    ->sortable(),
                TextColumn::make('nama_kapal')
                    ->searchable(),
                TextColumn::make('tipe_kapal')
                    ->searchable()->action(
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
                TextColumn::make('nama_perusahaan')
                    ->searchable(),
                TextColumn::make('tgl_tiba')
                    ->searchable(),
                TextColumn::make('tgl_brangkat')
                    ->searchable(),
                TextColumn::make('bendera')
                    ->searchable(),
                TextColumn::make('gt_kapal')
                    ->numeric()
                    ->sortable(),
                TextColumn::make('dwt')
                    ->numeric()
                    ->sortable(),
                TextColumn::make('no_imo')
                    ->searchable(),
                TextColumn::make('call_sign')
                    ->searchable(),
                TextColumn::make('nakhoda')
                    ->searchable(),
                TextColumn::make('jenis_trayek')
                    ->searchable(),
                TextColumn::make('pelabuhan_asal')
                    ->searchable(),
                TextColumn::make('pelabuhan_tujuan')
                    ->searchable(),
                TextColumn::make('lokasi_lambat_labuh')
                    ->searchable(),
                TextColumn::make('waktu_respon')
                    ->searchable(),
                TextColumn::make('nomor_spog')
                    ->searchable(),
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

                        if ($record->tipe_kapal !== 'TONGKANG / BARGE') {
                            return true; // Hide the action
                        }

                        return false;
                    })
                    ->badgeColor('success')
                    ->label('Reassign')
                    ->labeledFrom('md')
                    ->form([
                        // Select::make('no_pkk_assign')
                        //     ->label('No PKK')
                        //     ->required()
                            // ->relationship(
                            //     name: 'assignId',
                            //     modifyQueryUsing: fn (Builder $query) => $query->orderBy('no_pkk')->orderBy('vessel_name'),
                            // )
                            // ->getOptionLabelFromRecordUsing(fn (Model $record) => "{$record->no_pkk} ~ {$record->vessel_name} ~ {$record->nama_perusahaan}")
                            // ->searchable(['no_pkk', 'vessel_name', 'nama_perusahaan'])
                            Select::make('no_pkk_assign')
                            ->label('No PKK')
                            ->native(false)
                            // ->relationship(
                            //     name: 'assignId',
                            //     modifyQueryUsing: fn (Builder $query) => $query->orderBy('no_pkk')->orderBy('vessel_name')->where('isAssign', 0),
                            // )
                            ->searchable(['no_pkk', 'vessel_name', 'nama_perusahaan'])
                            ->options(AisDataVessel::query()->whereNotNull('no_pkk')->where('isAssign', 0)->get()
                                ->map(function ($record) {
                                    return [
                                        'value' => $record->no_pkk,
                                        'label' => "{$record->no_pkk} ~ {$record->vessel_name} ~ {$record->nama_perusahaan}"
                                    ];
                                })
                                ->pluck('label', 'value'))
                    ])
                    ->action(function (array $data, InaportnetBongkarMuat $record): void {
                        $record->no_pkk_assign = $data['no_pkk_assign'];
                        $record->update();
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
        return view('livewire.list-barge-paired');
    }
}
