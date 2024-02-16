<?php

namespace App\Filament\Resources;

use App\Filament\Resources\ReportSopBuntutResource\Pages;
use AlperenErsoy\FilamentExport\Actions\FilamentExportHeaderAction;
use App\Filament\Resources\ReportSopBuntutResource\RelationManagers;
use App\Models\ReportSopBuntut;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables\Actions\Action;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Filament\Tables\Columns\TextColumn;
use Malzariey\FilamentDaterangepickerFilter\Filters\DateRangeFilter;

class ReportSopBuntutResource extends Resource
{
    protected static ?string $model = ReportSopBuntut::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    protected static ?string $navigationGroup = 'Report';

    protected static ?string $navigationLabel = 'Report SOP BUNTUT';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                //
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('no_pkk')->searchable(),
                TextColumn::make('vessel_name')->searchable(),
                TextColumn::make('nama_perusahaan')->searchable(),
                TextColumn::make('vessel_type'),
                TextColumn::make('draught')->numeric(),
                TextColumn::make('dimension_to_bow')->numeric(),
                TextColumn::make('dimension_to_stern')->numeric(),
                TextColumn::make('dimension_to_port')->numeric(),
                TextColumn::make('dimension_to_starboard')->numeric(),
                TextColumn::make('bendera'),
                TextColumn::make('tgl_tiba'),
                TextColumn::make('pelabuhan_asal')->searchable(),
                TextColumn::make('lokasi_lambat_labuh'),
                TextColumn::make('tgl_brangkat'),
                TextColumn::make('pelabuhan_tujuan')->searchable(),
                TextColumn::make('geofence_id'),
                TextColumn::make('in'),
                TextColumn::make('out'),
                TextColumn::make('total_time')->numeric(),
                TextColumn::make('created_at'),
            ])
            ->filters([
                Tables\Filters\SelectFilter::make('vessel_type')
                    ->options([
                        'Fishing' => 'Fishing',
                        'Tug' => 'Tug',
                        'Cargo' => 'Cargo',
                    ]),
                Tables\Filters\SelectFilter::make('bendera')
                    ->options([
                        'ID' => 'Indonesia',
                    ]),
                Tables\Filters\SelectFilter::make('pelabuhan_asal')
                    ->options([
                        'Kelanis' => 'Kelanis',
                    ]),
                DateRangeFilter::make('tgl_tiba'),
                DateRangeFilter::make('in')->label('Masuk Geofence'),
                DateRangeFilter::make('out')->label('Keluar Geofence'),
                DateRangeFilter::make('tgl_brangkat'),
            ])->filtersFormColumns(2)->filtersTriggerAction(
                fn (Action $action) => $action
                    ->button()
                    ->label('Filter'),
            )
            ->actions([
                // Tables\Actions\EditAction::make(),
            ])
            ->headerActions([
                FilamentExportHeaderAction::make('export')->disableAdditionalColumns() // Disable additional columns input
                    ->disableFilterColumns()
            ])
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
            'index' => Pages\ListReportSopBuntuts::route('/'),
            'create' => Pages\CreateReportSopBuntut::route('/create'),
            'edit' => Pages\EditReportSopBuntut::route('/{record}/edit'),
        ];
    }
}
