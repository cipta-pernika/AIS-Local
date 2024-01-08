<?php

namespace App\Filament\Resources;

use App\Filament\Resources\PelabuhanResource\Pages;
use App\Filament\Resources\PelabuhanResource\RelationManagers;
use App\Models\Pelabuhan;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class PelabuhanResource extends Resource
{
    protected static ?string $model = Pelabuhan::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    protected static ?string $navigationGroup = 'Master Data';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('name')
                    ->required()
                    ->maxLength(255),
                Forms\Components\TextInput::make('un_locode')
                    ->required()
                    ->maxLength(255),
                Forms\Components\TextInput::make('latitude')
                    ->required()
                    ->numeric(),
                Forms\Components\TextInput::make('longitude')
                    ->required()
                    ->numeric(),
                Forms\Components\TextInput::make('radius')
                    ->maxLength(255),
                Forms\Components\TextInput::make('address')
                    ->maxLength(255),
                Forms\Components\TextInput::make('penanggung_jawab')
                    ->maxLength(255),
                Forms\Components\TextInput::make('no_izin_pengoperasian')
                    ->maxLength(255),
                Forms\Components\TextInput::make('tgl_izin_pengoperasian')
                    ->maxLength(255),
                Forms\Components\TextInput::make('penerbit_izin_pengoperasian')
                    ->maxLength(255),
                Forms\Components\TextInput::make('no_perjanjian_sewa_perairan')
                    ->maxLength(255),
                Forms\Components\TextInput::make('tgl_sewa_perairan')
                    ->maxLength(255),
                Forms\Components\TextInput::make('luas_perairan')
                    ->numeric(),
                Forms\Components\TextInput::make('jasa_pengunaan_perairan')
                    ->numeric(),
                Forms\Components\TextInput::make('keterangan')
                    ->maxLength(255),
                Forms\Components\TextInput::make('masa_berlaku_izin_operasi')
                    ->maxLength(255),
                Forms\Components\TextInput::make('masa_berlaku_perjanjian_sewa_perairan')
                    ->maxLength(255),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('name')
                    ->searchable(),
                Tables\Columns\TextColumn::make('un_locode')
                    ->searchable(),
                Tables\Columns\TextColumn::make('latitude')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('longitude')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('radius')
                    ->searchable(),
                Tables\Columns\TextColumn::make('address')
                    ->searchable(),
                Tables\Columns\TextColumn::make('penanggung_jawab')
                    ->searchable(),
                Tables\Columns\TextColumn::make('no_izin_pengoperasian')
                    ->searchable(),
                Tables\Columns\TextColumn::make('tgl_izin_pengoperasian')
                    ->searchable(),
                Tables\Columns\TextColumn::make('penerbit_izin_pengoperasian')
                    ->searchable(),
                Tables\Columns\TextColumn::make('no_perjanjian_sewa_perairan')
                    ->searchable(),
                Tables\Columns\TextColumn::make('tgl_sewa_perairan')
                    ->searchable(),
                Tables\Columns\TextColumn::make('luas_perairan')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('jasa_pengunaan_perairan')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('keterangan')
                    ->searchable(),
                Tables\Columns\TextColumn::make('masa_berlaku_izin_operasi')
                    ->searchable(),
                Tables\Columns\TextColumn::make('masa_berlaku_perjanjian_sewa_perairan')
                    ->searchable(),
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
            'index' => Pages\ListPelabuhans::route('/'),
            'create' => Pages\CreatePelabuhan::route('/create'),
            'edit' => Pages\EditPelabuhan::route('/{record}/edit'),
        ];
    }
}
