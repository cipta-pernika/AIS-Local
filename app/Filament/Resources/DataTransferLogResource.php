<?php

namespace App\Filament\Resources;

use App\Filament\Resources\DataTransferLogResource\Pages;
use App\Filament\Resources\DataTransferLogResource\RelationManagers;
use App\Models\DataTransferLog;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class DataTransferLogResource extends Resource
{
    protected static ?string $model = DataTransferLog::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    protected static ?string $navigationGroup = 'Logs';

    protected static ?int $navigationSort = 99;

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\DateTimePicker::make('timestamp')
                    ->required(),
                Forms\Components\TextInput::make('response_code')
                    ->required()
                    ->numeric(),
                Forms\Components\TextInput::make('response_time')
                    ->numeric(),
                Forms\Components\Textarea::make('additional_info')
                    ->maxLength(65535)
                    ->columnSpanFull(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('timestamp')
                    ->dateTime()
                    ->sortable(),
                Tables\Columns\TextColumn::make('response_code')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('response_time')
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
            'index' => Pages\ListDataTransferLogs::route('/'),
            'create' => Pages\CreateDataTransferLog::route('/create'),
            'edit' => Pages\EditDataTransferLog::route('/{record}/edit'),
        ];
    }
}
