<?php

namespace App\Filament\Pages;

use Carbon\Carbon;
use Filament\Pages\Page;
use Filament\Forms\Contracts\HasForms;
use Filament\Forms\Form;
use Filament\Forms\Concerns\InteractsWithForms;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\DateTimePicker;
use Filament\Forms\Components\Actions;
use Filament\Forms\Components\Actions\Action;
use Filament\Support\Enums\ActionSize;
use Filament\Support\Enums\VerticalAlignment;

class Playback extends Page implements HasForms
{
    use InteractsWithForms;
    protected static ?string $navigationIcon = 'heroicon-o-backward';

    protected static string $view = 'filament.pages.playback';

    public $startDate = null, $endDate = null;

    public ?array $data = [];

    public static function shouldRegisterNavigation(): bool
    {
        return false;
    }

    public function mount(): void
    {
        $this->startDate = Carbon::yesterday();
        $this->endDate = Carbon::now();
        $this->form->fill();
    }

    public function form(Form $form): Form
    {
        return $form
            ->schema([
                Section::make('Filter')
                    ->schema([
                        DateTimePicker::make('start_date')->seconds(false)->format('Y-m-d H:i')->displayFormat('Y-m-d H:i')->minutesStep(30)->native(false)
                            ->default($this->startDate)->timezone('Asia/Jakarta')->placeholder($this->startDate),
                        DateTimePicker::make('end_date')->seconds(false)->format('Y-m-d H:i')->displayFormat('Y-m-d H:i')->minutesStep(30)->native(false)
                            ->default($this->endDate)->timezone('Asia/Jakarta')->placeholder($this->endDate),
                        Actions::make([
                            Action::make('submit')->outlined()->color('primary')
                                ->action(function () {
                                    $this->startDate = $this->data['start_date'].':00';
                                    $this->endDate = $this->data['end_date'].':00';
                                })
                        ])->verticalAlignment(VerticalAlignment::End),
                    ])
                    ->columns(4),
            ])
            ->statePath('data');
    }

    public function summary()
    {
        
    }
}
