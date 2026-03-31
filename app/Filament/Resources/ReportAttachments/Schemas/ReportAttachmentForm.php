<?php

namespace App\Filament\Resources\ReportAttachments\Schemas;

use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;

class ReportAttachmentForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make('بيانات المرفق')
                    ->schema([
                        Select::make('report_id')
                            ->label('البلاغ')
                            ->relationship('report', 'tracking_code')
                            ->searchable()
                            ->preload()
                            ->required(),
                        TextInput::make('file_name')->label('اسم الملف')->required()->maxLength(255),
                        TextInput::make('mime_type')->label('نوع الملف')->required()->maxLength(255),
                        TextInput::make('file_path')->label('المسار')->required()->maxLength(65535)->columnSpanFull(),
                        TextInput::make('file_size')->label('الحجم')->numeric(),
                        TextInput::make('caption')->label('وصف مختصر')->maxLength(255),
                    ])
                    ->columns(2),
            ]);
    }
}
