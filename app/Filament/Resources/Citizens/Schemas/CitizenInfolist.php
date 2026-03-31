<?php

namespace App\Filament\Resources\Citizens\Schemas;

use App\Support\CleanStreetsOptions;
use Filament\Infolists\Components\TextEntry;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;

class CitizenInfolist
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make('تفاصيل المواطن')
                    ->schema([
                        TextEntry::make('full_name')->label('الاسم الكامل'),
                        TextEntry::make('phone')->label('الهاتف'),
                        TextEntry::make('whatsapp_phone')->label('واتساب'),
                        TextEntry::make('email')->label('البريد الإلكتروني'),
                        TextEntry::make('preferred_contact_method')
                            ->label('وسيلة التواصل المفضلة')
                            ->formatStateUsing(fn (?string $state): string => CleanStreetsOptions::contactMethods()[$state] ?? (string) $state),
                        TextEntry::make('notes')->label('ملاحظات')->columnSpanFull(),
                        TextEntry::make('created_at')->label('أنشئ')->dateTime(),
                    ])
                    ->columns(2),
            ]);
    }
}
