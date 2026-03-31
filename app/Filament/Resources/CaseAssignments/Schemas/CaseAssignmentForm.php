<?php

namespace App\Filament\Resources\CaseAssignments\Schemas;

use App\Support\CleanStreetsOptions;
use Filament\Forms\Components\DateTimePicker;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;

class CaseAssignmentForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make('بيانات الإسناد')
                    ->schema([
                        Select::make('vehicle_case_id')
                            ->label('الحالة')
                            ->relationship('vehicleCase', 'case_number')
                            ->searchable()
                            ->preload()
                            ->required(),
                        Select::make('agency_id')
                            ->label('الجهة')
                            ->relationship('agency', 'name')
                            ->searchable()
                            ->preload()
                            ->required(),
                        Select::make('assigned_to_user_id')
                            ->label('المستخدم المكلف')
                            ->relationship('assignedTo', 'name')
                            ->searchable()
                            ->preload(),
                        Select::make('assigned_by_user_id')
                            ->label('أسنده المستخدم')
                            ->relationship('assignedBy', 'name')
                            ->searchable()
                            ->preload(),
                        Select::make('assignment_status')
                            ->label('الحالة')
                            ->options(CleanStreetsOptions::assignmentStatuses())
                            ->required(),
                        DateTimePicker::make('assigned_at')->label('تاريخ الإسناد'),
                        DateTimePicker::make('responded_at')->label('تاريخ الاستجابة'),
                        DateTimePicker::make('due_at')->label('الموعد النهائي'),
                        DateTimePicker::make('completed_at')->label('تاريخ الإكمال'),
                        Textarea::make('notes')
                            ->label('ملاحظات')
                            ->rows(4)
                            ->columnSpanFull(),
                    ])
                    ->columns(2),
            ]);
    }
}
