<?php

namespace App\Filament\Resources\CaseAttachments\Schemas;

use App\Support\CleanStreetsOptions;
use Filament\Infolists\Components\ImageEntry;
use Filament\Infolists\Components\TextEntry;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;

class CaseAttachmentInfolist
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make('تفاصيل المرفق')
                    ->schema([
                        ImageEntry::make('public_url')
                            ->label('الصورة')
                            ->columnSpanFull(),
                        TextEntry::make('vehicleCase.case_number')->label('الحالة'),
                        TextEntry::make('uploadedBy.name')->label('رفع بواسطة'),
                        TextEntry::make('category')
                            ->label('الفئة')
                            ->formatStateUsing(fn (?string $state): string => CleanStreetsOptions::attachmentCategories()[$state] ?? (string) $state),
                        TextEntry::make('file_name')->label('اسم الملف'),
                        TextEntry::make('mime_type')->label('نوع الملف'),
                        TextEntry::make('file_path')->label('المسار')->columnSpanFull(),
                        TextEntry::make('public_url')
                            ->label('رابط العرض')
                            ->url(fn (?string $state): ?string => $state, shouldOpenInNewTab: true)
                            ->columnSpanFull(),
                        TextEntry::make('notes')->label('ملاحظات')->columnSpanFull(),
                    ])
                    ->columns(2),
            ]);
    }
}
