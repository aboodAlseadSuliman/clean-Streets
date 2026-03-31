<?php

namespace App\Filament\Resources\Removals\Schemas;

use App\Support\CleanStreetsOptions;
use Filament\Infolists\Components\TextEntry;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;

class RemovalInfolist
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make('تفاصيل الإزالة')
                    ->schema([
                        TextEntry::make('vehicleCase.case_number')->label('الحالة'),
                        TextEntry::make('agency.name')->label('الجهة'),
                        TextEntry::make('executedBy.name')->label('نفذها'),
                        TextEntry::make('result')
                            ->label('النتيجة')
                            ->formatStateUsing(fn (?string $state): string => CleanStreetsOptions::removalResults()[$state] ?? (string) $state),
                        TextEntry::make('destination')->label('الوجهة'),
                        TextEntry::make('completed_at')->label('تمت في')->dateTime(),
                        TextEntry::make('notes')->label('ملاحظات')->columnSpanFull(),
                    ])
                    ->columns(2),
            ]);
    }
}
