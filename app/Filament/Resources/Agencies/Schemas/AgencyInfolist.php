<?php

namespace App\Filament\Resources\Agencies\Schemas;

use App\Support\CleanStreetsOptions;
use Filament\Infolists\Components\TextEntry;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;

class AgencyInfolist
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make('تفاصيل الجهة')
                    ->schema([
                        TextEntry::make('name')->label('اسم الجهة'),
                        TextEntry::make('type')
                            ->label('النوع')
                            ->formatStateUsing(fn (?string $state): string => CleanStreetsOptions::agencyTypes()[$state] ?? (string) $state),
                        TextEntry::make('phone')->label('الهاتف'),
                        TextEntry::make('email')->label('البريد الإلكتروني'),
                        TextEntry::make('address')->label('العنوان')->columnSpanFull(),
                        TextEntry::make('is_active')
                            ->label('الحالة')
                            ->formatStateUsing(fn (bool $state): string => $state ? 'مفعلة' : 'موقوفة'),
                        TextEntry::make('created_at')->label('تاريخ الإنشاء')->dateTime(),
                    ])
                    ->columns(2),
            ]);
    }
}
