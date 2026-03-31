<?php

namespace App\Filament\Resources\CaseStatusLogs\Schemas;

use App\Support\CleanStreetsOptions;
use Filament\Forms\Components\DateTimePicker;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;

class CaseStatusLogForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make('بيانات السجل')
                    ->schema([
                        Select::make('vehicle_case_id')
                            ->label('الحالة')
                            ->relationship('vehicleCase', 'case_number')
                            ->searchable()
                            ->preload()
                            ->required(),
                        TextInput::make('from_status')
                            ->label('من حالة')
                            ->maxLength(255),
                        Select::make('to_status')
                            ->label('إلى حالة')
                            ->options(CleanStreetsOptions::caseStatuses())
                            ->required(),
                        Select::make('changed_by_user_id')
                            ->label('تم التغيير بواسطة')
                            ->relationship('changedBy', 'name')
                            ->searchable()
                            ->preload(),
                        DateTimePicker::make('created_at')->label('تاريخ السجل'),
                        Textarea::make('reason')
                            ->label('السبب')
                            ->rows(4)
                            ->columnSpanFull(),
                    ])
                    ->columns(2),
            ]);
    }
}
