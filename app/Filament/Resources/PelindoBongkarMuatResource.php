<?php

namespace App\Filament\Resources;

use App\Filament\Resources\PelindoBongkarMuatResource\Pages;
use App\Filament\Resources\PelindoBongkarMuatResource\RelationManagers;
use App\Models\PelindoBongkarMuat;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use App\Filament\Tables\Columns\ViewColumn;

class PelindoBongkarMuatResource extends Resource
{
    protected static ?string $model = PelindoBongkarMuat::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

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
                Forms\Components\TextInput::make('nama_agent')
                    ->maxLength(255),
                Forms\Components\TextInput::make('ppk')
                    ->maxLength(255),
                Forms\Components\TextInput::make('gt_kapal')
                    ->numeric(),
                Forms\Components\TextInput::make('dwt')
                    ->numeric(),
                Forms\Components\TextInput::make('loa')
                    ->numeric(),
                Forms\Components\TextInput::make('nama_dermaga')
                    ->maxLength(255),
                Forms\Components\TextInput::make('rea_mulai_bm')
                    ->maxLength(255),
                Forms\Components\TextInput::make('rea_selesai_bm')
                    ->maxLength(255),
                Forms\Components\TextInput::make('jumlah_biaya')
                    ->numeric(),
                Forms\Components\TextInput::make('jumlah_pnbp')
                    ->numeric(),
                Forms\Components\TextInput::make('id_rkbm')
                    ->maxLength(255),
                Forms\Components\TextInput::make('pbm')
                    ->maxLength(255),
                Forms\Components\TextInput::make('kegiatan_bongkar_muat')
                    ->maxLength(255),
                Forms\Components\TextInput::make('jenis_barang')
                    ->maxLength(255),
                Forms\Components\TextInput::make('jumlah_barang')
                    ->numeric(),
                Forms\Components\DateTimePicker::make('rea_mulai_tambat'),
                Forms\Components\DateTimePicker::make('rea_selesai_tambat'),
                Forms\Components\DateTimePicker::make('created_at_pelindo'),
                Forms\Components\Textarea::make('image_mulai')
                    ->columnSpanFull(),
                Forms\Components\Textarea::make('image_sedang')
                    ->columnSpanFull(),
                Forms\Components\Textarea::make('image_selesai')
                    ->columnSpanFull(),
                Forms\Components\FileUpload::make('image_mulai_2')
                    ->image()
                    ->required(),
                Forms\Components\FileUpload::make('image_sedang_2')
                    ->image()
                    ->required(),
                Forms\Components\FileUpload::make('image_selesai_2')
                    ->image()
                    ->required(),
                Forms\Components\FileUpload::make('image_mulai_3')
                    ->image()
                    ->required(),
                Forms\Components\FileUpload::make('image_sedang_3')
                    ->image()
                    ->required(),
                Forms\Components\FileUpload::make('image_selesai_3')
                    ->image()
                    ->required(),
                Forms\Components\TextInput::make('no_pkk_assign')
                    ->maxLength(255),
                Forms\Components\TextInput::make('mmsi')
                    ->maxLength(255),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('no_pkk')
                    ->searchable(),
                Tables\Columns\TextColumn::make('ais_data_vessel_id')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('nama_kapal')
                    ->searchable(),
                Tables\Columns\TextColumn::make('nama_agent')
                    ->searchable(),
                Tables\Columns\TextColumn::make('ppk')
                    ->searchable(),
                Tables\Columns\TextColumn::make('gt_kapal')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('dwt')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('loa')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('nama_dermaga')
                    ->searchable(),
                Tables\Columns\TextColumn::make('rea_mulai_bm')
                    ->searchable(),
                Tables\Columns\TextColumn::make('rea_selesai_bm')
                    ->searchable(),
                Tables\Columns\TextColumn::make('jumlah_biaya')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('jumlah_pnbp')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('id_rkbm')
                    ->searchable(),
                Tables\Columns\TextColumn::make('pbm')
                    ->searchable(),
                Tables\Columns\TextColumn::make('kegiatan_bongkar_muat')
                    ->searchable(),
                Tables\Columns\TextColumn::make('jenis_barang')
                    ->searchable(),
                Tables\Columns\TextColumn::make('jumlah_barang')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('rea_mulai_tambat')
                    ->dateTime()
                    ->sortable(),
                Tables\Columns\TextColumn::make('rea_selesai_tambat')
                    ->dateTime()
                    ->sortable(),
                Tables\Columns\TextColumn::make('created_at_pelindo')
                    ->dateTime()
                    ->sortable(),
                Tables\Columns\ImageColumn::make('image_mulai_2'),
                Tables\Columns\ImageColumn::make('image_sedang_2'),
                Tables\Columns\ImageColumn::make('image_selesai_2'),
                Tables\Columns\ImageColumn::make('image_mulai_3'),
                Tables\Columns\ImageColumn::make('image_sedang_3'),
                Tables\Columns\ImageColumn::make('image_selesai_3'),
                Tables\Columns\TextColumn::make('no_pkk_assign')
                    ->searchable(),
                Tables\Columns\TextColumn::make('mmsi')
                    ->searchable(),
                ViewColumn::make('image_mulai')
                    ->view('filament.tables.columns.image-column')
                    ->label('Mulai Bongkar/Muat'),
                ViewColumn::make('image_sedang')
                    ->view('filament.tables.columns.image-column-sedang')
                    ->label('Sedang Bongkar/Muat'),
                ViewColumn::make('image_selesai')
                    ->view('filament.tables.columns.image-column-akhir')
                    ->label('Selesai Bongkar/Muat'),
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
            'index' => Pages\ListPelindoBongkarMuats::route('/'),
            'create' => Pages\CreatePelindoBongkarMuat::route('/create'),
            'edit' => Pages\EditPelindoBongkarMuat::route('/{record}/edit'),
        ];
    }
}
