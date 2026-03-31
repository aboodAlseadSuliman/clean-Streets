<?php

namespace App\Filament\Resources\CaseAttachments\Schemas;

use App\Support\CleanStreetsOptions;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;

class CaseAttachmentForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make('بيانات المرفق')
                    ->schema([
                        Select::make('vehicle_case_id')
                            ->label('الحالة')
                            ->relationship('vehicleCase', 'case_number')
                            ->searchable()
                            ->preload()
                            ->required(),
                        Select::make('uploaded_by_user_id')
                            ->label('رفع بواسطة')
                            ->relationship('uploadedBy', 'name')
                            ->searchable()
                            ->preload(),
                        Select::make('category')
                            ->label('الفئة')
                            ->options(CleanStreetsOptions::attachmentCategories())
                            ->required(),
                        TextInput::make('file_name')->label('اسم الملف')->required()->maxLength(255),
                        TextInput::make('mime_type')->label('نوع الملف')->required()->maxLength(255),
                        TextInput::make('file_path')->label('المسار')->required()->maxLength(65535)->columnSpanFull(),
                        TextInput::make('file_size')->label('الحجم')->numeric(),
                        Textarea::make('notes')->label('ملاحظات')->rows(3)->columnSpanFull(),
                    ])
                    ->columns(2),
            ]);
    }
}
