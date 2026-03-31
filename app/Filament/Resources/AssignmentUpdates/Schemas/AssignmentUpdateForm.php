<?php

namespace App\Filament\Resources\AssignmentUpdates\Schemas;

use App\Support\CleanStreetsOptions;
use Filament\Forms\Components\DateTimePicker;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;

class AssignmentUpdateForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make('بيانات التحديث')
                    ->schema([
                        Select::make('case_assignment_id')
                            ->label('الإسناد')
                            ->relationship('caseAssignment', 'assignment_status')
                            ->searchable()
                            ->preload()
                            ->required(),
                        Select::make('agency_id')
                            ->label('الجهة')
                            ->relationship('agency', 'name')
                            ->searchable()
                            ->preload(),
                        Select::make('user_id')
                            ->label('المستخدم')
                            ->relationship('user', 'name')
                            ->searchable()
                            ->preload(),
                        Select::make('update_type')
                            ->label('نوع التحديث')
                            ->options(CleanStreetsOptions::assignmentUpdateTypes())
                            ->required(),
                        DateTimePicker::make('created_at')->label('تاريخ التحديث'),
                        Textarea::make('message')
                            ->label('الرسالة')
                            ->required()
                            ->rows(4)
                            ->columnSpanFull(),
                    ])
                    ->columns(2),
            ]);
    }
}
