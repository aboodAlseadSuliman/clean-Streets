<?php

namespace App\Filament\Resources\Users\Schemas;

use App\Support\CleanStreetsOptions;
use Filament\Infolists\Components\TextEntry;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;

class UserInfolist
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make('تفاصيل المستخدم')
                    ->schema([
                        TextEntry::make('name')->label('الاسم'),
                        TextEntry::make('email')->label('البريد الإلكتروني'),
                        TextEntry::make('phone')->label('الهاتف'),
                        TextEntry::make('agency.name')->label('الجهة'),
                        TextEntry::make('role')
                            ->label('الدور')
                            ->formatStateUsing(fn (?string $state): string => CleanStreetsOptions::userRoles()[$state] ?? (string) $state),
                        TextEntry::make('is_active')
                            ->label('الحالة')
                            ->formatStateUsing(fn (bool $state): string => $state ? 'نشط' : 'موقوف'),
                        TextEntry::make('created_at')->label('أنشئ في')->dateTime(),
                    ])
                    ->columns(2),
            ]);
    }
}
