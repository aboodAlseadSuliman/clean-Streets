<?php

namespace App\Filament\Resources\Neighborhoods\Schemas;

use Filament\Infolists\Components\TextEntry;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;

class NeighborhoodInfolist
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make('تفاصيل الحي')
                    ->schema([
                        TextEntry::make('name')->label('اسم الحي'),
                        TextEntry::make('district.name')->label('المنطقة'),
                        TextEntry::make('code')->label('الرمز'),
                        TextEntry::make('created_at')->label('أنشئ')->dateTime(),
                    ])
                    ->columns(2),
            ]);
    }
}
