<?php

namespace App\Filament\Resources\Inspections\Schemas;

use App\Support\CleanStreetsOptions;
use Filament\Forms\Components\DateTimePicker;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;

class InspectionForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make('بيانات التحقق')
                    ->schema([
                        Select::make('vehicle_case_id')
                            ->label('الحالة')
                            ->relationship('vehicleCase', 'case_number')
                            ->searchable()
                            ->preload()
                            ->required(),
                        Select::make('inspector_user_id')
                            ->label('المفتش')
                            ->relationship('inspector', 'name')
                            ->searchable()
                            ->preload(),
                        Select::make('agency_id')
                            ->label('الجهة')
                            ->relationship('agency', 'name')
                            ->searchable()
                            ->preload(),
                        Select::make('inspection_result')
                            ->label('النتيجة')
                            ->options(CleanStreetsOptions::inspectionResults())
                            ->required(),
                        DateTimePicker::make('inspected_at')->label('وقت التحقق'),
                        Textarea::make('notes')
                            ->label('ملاحظات')
                            ->rows(4)
                            ->columnSpanFull(),
                    ])
                    ->columns(2),
            ]);
    }
}
