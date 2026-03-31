<?php

namespace App\Filament\Resources\Districts\Schemas;

use Filament\Infolists\Components\TextEntry;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;

class DistrictInfolist
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make('تفاصيل المنطقة')
                    ->schema([
                        TextEntry::make('name')->label('اسم المنطقة'),
                        TextEntry::make('code')->label('الرمز'),
                        TextEntry::make('created_at')->label('أنشئت')->dateTime(),
                    ])
                    ->columns(2),
            ]);
    }
}
