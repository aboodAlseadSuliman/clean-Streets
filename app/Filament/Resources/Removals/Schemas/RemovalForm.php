<?php

namespace App\Filament\Resources\Removals\Schemas;

use App\Support\CleanStreetsOptions;
use Filament\Forms\Components\DateTimePicker;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;

class RemovalForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make('بيانات الإزالة')
                    ->schema([
                        Select::make('vehicle_case_id')
                            ->label('الحالة')
                            ->relationship('vehicleCase', 'case_number')
                            ->searchable()
                            ->preload()
                            ->required(),
                        Select::make('case_assignment_id')
                            ->label('الإسناد')
                            ->relationship('caseAssignment', 'assignment_status')
                            ->searchable()
                            ->preload(),
                        Select::make('agency_id')
                            ->label('الجهة')
                            ->relationship('agency', 'name')
                            ->searchable()
                            ->preload()
                            ->required(),
                        Select::make('executed_by_user_id')
                            ->label('نفذه المستخدم')
                            ->relationship('executedBy', 'name')
                            ->searchable()
                            ->preload(),
                        Select::make('result')
                            ->label('النتيجة')
                            ->options(CleanStreetsOptions::removalResults()),
                        DateTimePicker::make('scheduled_at')->label('موعد الإزالة'),
                        DateTimePicker::make('started_at')->label('بدء التنفيذ'),
                        DateTimePicker::make('completed_at')->label('نهاية التنفيذ'),
                        TextInput::make('destination')->label('الوجهة')->maxLength(255),
                        Textarea::make('notes')
                            ->label('ملاحظات')
                            ->rows(4)
                            ->columnSpanFull(),
                    ])
                    ->columns(2),
            ]);
    }
}
