<?php

namespace App\Filament\Resources;

use App\Filament\Resources\AisDataPositionResource\Pages;
use App\Filament\Resources\AisDataPositionResource\RelationManagers;
use App\Models\AisDataPosition;
use App\Models\AisDataVessel;
use App\Models\Pelabuhan;
use Carbon\Carbon;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use pxlrbt\FilamentExcel\Actions\Tables\ExportBulkAction;
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

class AisDataPositionResource extends Resource
{
    protected static ?string $model = AisDataPosition::class;

    protected static ?string $navigationIcon = 'heroicon-m-globe-asia-australia';

    protected static ?string $navigationGroup = 'AIS';

    

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('sensor_data_id')
                    ->required()
                    ->numeric(),
                Forms\Components\TextInput::make('vessel_id')
                    ->required()
                    ->numeric(),
                Forms\Components\TextInput::make('latitude')
                    ->required()
                    ->numeric(),
                Forms\Components\TextInput::make('longitude')
                    ->required()
                    ->numeric(),
                Forms\Components\TextInput::make('speed')
                    ->required()
                    ->numeric(),
                Forms\Components\TextInput::make('course')
                    ->numeric(),
                Forms\Components\TextInput::make('heading')
                    ->numeric(),
                Forms\Components\TextInput::make('navigation_status')
                    ->maxLength(255),
                Forms\Components\TextInput::make('turning_rate')
                    ->numeric(),
                Forms\Components\Toggle::make('turning_direction'),
                Forms\Components\DateTimePicker::make('timestamp')
                    ->required(),
                Forms\Components\TextInput::make('distance')
                    ->numeric(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('vessel.mmsi')
                    ->label('MMSI')
                    ->searchable()
                    ->sortable(),
                Tables\Columns\TextColumn::make('vessel.vessel_name')
                    ->label('Nama Kapal')
                    ->searchable()
                    ->sortable(),
                Tables\Columns\TextColumn::make('latitude')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('longitude')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('speed')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('course')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('heading')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('navigation_status')
                    ->searchable(),
                Tables\Columns\TextColumn::make('turning_rate')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\IconColumn::make('turning_direction')
                    ->boolean(),
                Tables\Columns\TextColumn::make('timestamp')
                    ->dateTime()
                    ->sortable(),
                Tables\Columns\TextColumn::make('distance')
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
                Tables\Filters\SelectFilter::make('vessel_id')
                    ->searchable()
                    ->options(AisDataVessel::whereNotNull('vessel_name')->get()->pluck('vessel_name', 'id')),
                DateRangeFilter::make('updated_at')->startDate(Carbon::now()->subDays(7))->endDate(Carbon::now()),
                QueryBuilder::make()
                    ->constraints([
                        TextConstraint::make('vessel.mmsi'),
                    ])
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                    ExportBulkAction::make()->label('Export')
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
            'index' => Pages\ListAisDataPositions::route('/'),
            'create' => Pages\CreateAisDataPosition::route('/create'),
            'edit' => Pages\EditAisDataPosition::route('/{record}/edit'),
        ];
    }
}
