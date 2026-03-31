<?php

namespace App\Filament\Resources\AssignmentUpdates\Schemas;

use App\Support\CleanStreetsOptions;
use Filament\Infolists\Components\TextEntry;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;

class AssignmentUpdateInfolist
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make('تفاصيل التحديث')
                    ->schema([
                        TextEntry::make('caseAssignment.id')->label('الإسناد'),
                        TextEntry::make('agency.name')->label('الجهة'),
                        TextEntry::make('user.name')->label('المستخدم'),
                        TextEntry::make('update_type')
                            ->label('نوع التحديث')
                            ->formatStateUsing(fn (?string $state): string => CleanStreetsOptions::assignmentUpdateTypes()[$state] ?? (string) $state),
                        TextEntry::make('message')->label('الرسالة')->columnSpanFull(),
                        TextEntry::make('created_at')->label('أنشئ')->dateTime(),
                    ])
                    ->columns(2),
            ]);
    }
}
