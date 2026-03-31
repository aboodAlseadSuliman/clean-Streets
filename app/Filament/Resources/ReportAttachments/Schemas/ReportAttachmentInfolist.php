<?php

namespace App\Filament\Resources\ReportAttachments\Schemas;

use Filament\Infolists\Components\ImageEntry;
use Filament\Infolists\Components\TextEntry;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;

class ReportAttachmentInfolist
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
                        TextEntry::make('report.tracking_code')->label('البلاغ'),
                        TextEntry::make('file_name')->label('اسم الملف'),
                        TextEntry::make('mime_type')->label('نوع الملف'),
                        TextEntry::make('file_path')->label('المسار')->columnSpanFull(),
                        TextEntry::make('public_url')
                            ->label('رابط العرض')
                            ->url(fn (?string $state): ?string => $state, shouldOpenInNewTab: true)
                            ->columnSpanFull(),
                        TextEntry::make('file_size')->label('الحجم'),
                        TextEntry::make('caption')->label('الوصف'),
                    ])
                    ->columns(2),
            ]);
    }
}
