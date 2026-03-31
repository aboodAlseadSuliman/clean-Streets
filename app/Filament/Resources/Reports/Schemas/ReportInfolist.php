<?php

namespace App\Filament\Resources\Reports\Schemas;

use App\Support\CleanStreetsOptions;
use Filament\Infolists\Components\TextEntry;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;

class ReportInfolist
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make('تفاصيل البلاغ')
                    ->schema([
                        TextEntry::make('tracking_code')->label('رمز التتبع'),
                        TextEntry::make('citizen.full_name')->label('المواطن'),
                        TextEntry::make('vehicleCase.case_number')->label('الحالة'),
                        TextEntry::make('request_type')
                            ->label('نوع الطلب')
                            ->formatStateUsing(fn (?string $state): string => CleanStreetsOptions::requestTypes()[$state] ?? (string) $state),
                        TextEntry::make('submission_channel')
                            ->label('قناة الإدخال')
                            ->formatStateUsing(fn (?string $state): string => CleanStreetsOptions::submissionChannels()[$state] ?? (string) $state),
                        TextEntry::make('public_status')
                            ->label('الحالة العامة')
                            ->formatStateUsing(fn (?string $state): string => CleanStreetsOptions::reportPublicStatuses()[$state] ?? (string) $state),
                        TextEntry::make('internal_status')
                            ->label('الحالة الداخلية')
                            ->formatStateUsing(fn (?string $state): string => CleanStreetsOptions::reportInternalStatuses()[$state] ?? (string) $state),
                        TextEntry::make('address_text')->label('العنوان')->columnSpanFull(),
                        TextEntry::make('google_maps_url')->label('رابط الخريطة')->columnSpanFull(),
                        TextEntry::make('complaint_details')->label('التفاصيل')->columnSpanFull(),
                        TextEntry::make('review_note')->label('ملاحظة المراجعة')->columnSpanFull(),
                        TextEntry::make('submitted_at')->label('أرسل في')->dateTime(),
                        TextEntry::make('reviewed_at')->label('تمت المراجعة في')->dateTime(),
                    ])
                    ->columns(2),
            ]);
    }
}
