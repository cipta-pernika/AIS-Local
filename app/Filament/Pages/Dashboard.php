<?php

namespace App\Filament\Pages;

use App\Models\AisDataVessel;
<<<<<<< HEAD
use App\Models\Pelabuhan;
=======
>>>>>>> coastal
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\Select;
use Filament\Forms\Form;
use Filament\Forms\Get;
use Filament\Pages\Dashboard as BaseDashboard;

class Dashboard extends BaseDashboard
{
<<<<<<< HEAD
    // use BaseDashboard\Concerns\HasFiltersForm;

    // public function filtersForm(Form $form): Form
    // {
    //     return $form
    //         ->schema([
    //             Section::make()
    //                 ->schema([
    //                     Select::make('pelabuhan_id')
    //                         ->native(false)
    //                         ->label('Pelabuhan')
    //                         ->multiple(false)->options(Pelabuhan::all()->pluck('name', 'id'))
    //                         ->searchable(),
    //                     DatePicker::make('startDate')
    //                         ->maxDate(fn (Get $get) => $get('endDate') ?: now()),
    //                     DatePicker::make('endDate')
    //                         ->minDate(fn (Get $get) => $get('startDate') ?: now())
    //                         ->maxDate(now()),
    //                 ])
    //                 ->columns(3),
    //         ]);
    // }
=======
    use BaseDashboard\Concerns\HasFiltersForm;

    public function filtersForm(Form $form): Form
    {
        return $form
            ->schema([
                Section::make()
                    ->schema([
                        DatePicker::make('startDate')
                            ->maxDate(fn (Get $get) => $get('endDate') ?: now()),
                        DatePicker::make('endDate')
                            ->minDate(fn (Get $get) => $get('startDate') ?: now())
                            ->maxDate(now()),
                    ])
                    ->columns(3),
            ]);
    }
>>>>>>> coastal
}
