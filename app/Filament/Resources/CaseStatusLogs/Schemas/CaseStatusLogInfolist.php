<?php

namespace App\Filament\Resources\CaseStatusLogs\Schemas;

use App\Support\CleanStreetsOptions;
use Filament\Infolists\Components\TextEntry;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;

class CaseStatusLogInfolist
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make('تفاصيل السجل')
                    ->schema([
                        TextEntry::make('vehicleCase.case_number')->label('الحالة'),
                        TextEntry::make('from_status')
                            ->label('من حالة')
                            ->formatStateUsing(fn (?string $state): string => CleanStreetsOptions::caseStatuses()[$state] ?? (string) $state),
                        TextEntry::make('to_status')
                            ->label('إلى حالة')
                            ->formatStateUsing(fn (?string $state): string => CleanStreetsOptions::caseStatuses()[$state] ?? (string) $state),
                        TextEntry::make('changedBy.name')->label('تم التغيير بواسطة'),
                        TextEntry::make('reason')->label('السبب')->columnSpanFull(),
                        TextEntry::make('created_at')->label('أنشئ')->dateTime(),
                    ])
                    ->columns(2),
            ]);
    }
}
