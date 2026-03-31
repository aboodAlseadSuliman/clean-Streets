<?php

namespace App\Filament\Resources\Inspections\Schemas;

use App\Support\CleanStreetsOptions;
use Filament\Infolists\Components\TextEntry;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;

class InspectionInfolist
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make('تفاصيل التحقق')
                    ->schema([
                        TextEntry::make('vehicleCase.case_number')->label('الحالة'),
                        TextEntry::make('inspector.name')->label('المفتش'),
                        TextEntry::make('agency.name')->label('الجهة'),
                        TextEntry::make('inspection_result')
                            ->label('النتيجة')
                            ->formatStateUsing(fn (?string $state): string => CleanStreetsOptions::inspectionResults()[$state] ?? (string) $state),
                        TextEntry::make('inspected_at')->label('وقت التحقق')->dateTime(),
                        TextEntry::make('notes')->label('ملاحظات')->columnSpanFull(),
                    ])
                    ->columns(2),
            ]);
    }
}
