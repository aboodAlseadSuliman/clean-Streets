<?php

namespace App\Filament\Resources\VehicleCases\Schemas;

use App\Support\CleanStreetsOptions;
use Filament\Infolists\Components\TextEntry;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;

class VehicleCaseInfolist
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make('تفاصيل الحالة')
                    ->schema([
                        TextEntry::make('case_number')->label('رقم الحالة'),
                        TextEntry::make('sourceReport.tracking_code')->label('البلاغ الأساسي'),
                        TextEntry::make('owningAgency.name')->label('الجهة المالكة'),
                        TextEntry::make('current_status')
                            ->label('الحالة')
                            ->formatStateUsing(fn (?string $state): string => CleanStreetsOptions::caseStatuses()[$state] ?? (string) $state),
                        TextEntry::make('priority')
                            ->label('الأولوية')
                            ->formatStateUsing(fn (?string $state): string => CleanStreetsOptions::casePriorities()[$state] ?? (string) $state),
                        TextEntry::make('neighborhood.name')->label('الحي'),
                        TextEntry::make('location_text')->label('الموقع')->columnSpanFull(),
                        TextEntry::make('vehicle_type')
                            ->label('نوع السيارة')
                            ->formatStateUsing(fn (?string $state): string => CleanStreetsOptions::vehicleTypes()[$state] ?? (string) $state),
                        TextEntry::make('damage_type')
                            ->label('نوع الضرر')
                            ->formatStateUsing(fn (?string $state): string => CleanStreetsOptions::damageTypes()[$state] ?? (string) $state),
                        TextEntry::make('reports_count')->label('عدد البلاغات'),
                    ])
                    ->columns(2),
            ]);
    }
}
