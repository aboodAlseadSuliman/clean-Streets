<?php

namespace App\Filament\Resources\CaseAssignments\Schemas;

use App\Support\CleanStreetsOptions;
use Filament\Infolists\Components\TextEntry;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;

class CaseAssignmentInfolist
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make('تفاصيل الإسناد')
                    ->schema([
                        TextEntry::make('vehicleCase.case_number')->label('الحالة'),
                        TextEntry::make('agency.name')->label('الجهة'),
                        TextEntry::make('assignedTo.name')->label('المستخدم المكلف'),
                        TextEntry::make('assignedBy.name')->label('أسنده'),
                        TextEntry::make('assignment_status')
                            ->label('الحالة')
                            ->formatStateUsing(fn (?string $state): string => CleanStreetsOptions::assignmentStatuses()[$state] ?? (string) $state),
                        TextEntry::make('due_at')->label('الموعد النهائي')->dateTime(),
                        TextEntry::make('notes')->label('ملاحظات')->columnSpanFull(),
                    ])
                    ->columns(2),
            ]);
    }
}
