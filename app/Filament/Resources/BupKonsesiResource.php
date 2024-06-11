<?php

namespace App\Filament\Resources;

use App\Filament\Resources\BupKonsesiResource\Pages;
use App\Filament\Resources\BupKonsesiResource\RelationManagers;
use App\Models\BupKonsesi;
use Filament\Forms;
use Filament\Forms\Components\Select;
use Filament\Forms\Form;
use Filament\Forms\Get;
use Filament\Forms\Set;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class BupKonsesiResource extends Resource
{
    protected static ?string $model = BupKonsesi::class;

    protected static ?string $navigationIcon = 'heroicon-o-currency-dollar';

    protected static ?string $navigationLabel = 'BUP Konsesi';

    public static function form(Form $form): Form
    {
        $months = [
            1 => 'January', 2 => 'February', 3 => 'March', 4 => 'April',
            5 => 'May', 6 => 'June', 7 => 'July', 8 => 'August',
            9 => 'September', 10 => 'October', 11 => 'November', 12 => 'December'
        ];

        return $form
            ->schema([
                Forms\Components\Select::make('bup')->options([
                    'PT. PELINDO' => 'PT. PELINDO',
                    'PT. INDONESIA MULTI PURPOSE TERMINAL' => 'PT. INDONESIA MULTI PURPOSE TERMINAL',
                    'PT. AMBANG BARITO NUSAPERSADA' => 'PT. AMBANG BARITO NUSAPERSADA',
                ])->native(false),
                Forms\Components\TextInput::make('bruto')
                    ->required()
                    ->numeric(),
                Forms\Components\Select::make('besaran_konsesi')->options([
                    '2.5' => '2,5%',
                    '4' => '4%',
                    '8' => '8%',
                ])->native(false)->reactive()
                    ->afterStateUpdated(function (Get $get, Set $set, Select $component) {
                        if ($get('bruto')) {
                            $set('pendapatan_konsesi', (int)$get('bruto') * (float)$get('besaran_konsesi'));
                        }
                    }),
                Forms\Components\TextInput::make('pendapatan_konsesi')
                    ->required()
                    ->numeric(),
                Forms\Components\Select::make('month')
                    ->options($months)->native(false)->searchable()->label('Data Bulan'),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('bup')
                    ->searchable(),
                Tables\Columns\TextColumn::make('bruto')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('besaran_konsesi')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('pendapatan_konsesi')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('month')
                    ->date()
                    ->sortable(),
                Tables\Columns\TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('updated_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('deleted_at')
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
            'index' => Pages\ListBupKonsesis::route('/'),
            'create' => Pages\CreateBupKonsesi::route('/create'),
            'edit' => Pages\EditBupKonsesi::route('/{record}/edit'),
        ];
    }
}
