<?php

namespace App\Filament\Resources\Reports\Schemas;

use App\Support\CleanStreetsOptions;
use Filament\Forms\Components\DateTimePicker;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;

class ReportForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make('معلومات البلاغ')
                    ->schema([
                        TextInput::make('tracking_code')
                            ->label('رمز التتبع')
                            ->required()
                            ->unique(ignoreRecord: true)
                            ->maxLength(255),
                        Select::make('citizen_id')
                            ->label('المواطن')
                            ->relationship('citizen', 'full_name')
                            ->searchable()
                            ->preload(),
                        Select::make('vehicle_case_id')
                            ->label('الحالة المرتبطة')
                            ->relationship('vehicleCase', 'case_number')
                            ->searchable()
                            ->preload(),
                        Select::make('submitted_by_user_id')
                            ->label('أدخله المستخدم')
                            ->relationship('submittedBy', 'name')
                            ->searchable()
                            ->preload(),
                        Select::make('request_type')
                            ->label('نوع الطلب')
                            ->options(CleanStreetsOptions::requestTypes())
                            ->required(),
                        Select::make('submission_channel')
                            ->label('قناة الإدخال')
                            ->options(CleanStreetsOptions::submissionChannels())
                            ->required(),
                        TextInput::make('subject')
                            ->label('العنوان')
                            ->maxLength(255)
                            ->columnSpanFull(),
                        Textarea::make('complaint_details')
                            ->label('تفاصيل الشكوى')
                            ->required()
                            ->rows(4)
                            ->columnSpanFull(),
                    ])
                    ->columns(2),
                Section::make('الموقع')
                    ->schema([
                        Textarea::make('address_text')
                            ->label('العنوان')
                            ->required()
                            ->rows(3)
                            ->columnSpanFull(),
                        TextInput::make('nearest_landmark')
                            ->label('أقرب معلم')
                            ->maxLength(255),
                        Select::make('district_id')
                            ->label('المنطقة')
                            ->relationship('district', 'name')
                            ->searchable()
                            ->preload(),
                        Select::make('neighborhood_id')
                            ->label('الحي')
                            ->relationship('neighborhood', 'name')
                            ->searchable()
                            ->preload(),
                        TextInput::make('google_maps_url')
                            ->label('رابط Google Maps')
                            ->url()
                            ->maxLength(65535)
                            ->columnSpanFull(),
                        TextInput::make('latitude')->label('Latitude')->numeric(),
                        TextInput::make('longitude')->label('Longitude')->numeric(),
                    ])
                    ->columns(2),
                Section::make('وصف السيارة والحالة')
                    ->schema([
                        Select::make('vehicle_type')
                            ->label('نوع السيارة')
                            ->options(CleanStreetsOptions::vehicleTypes()),
                        Select::make('damage_type')
                            ->label('نوع الضرر')
                            ->options(CleanStreetsOptions::damageTypes()),
                        TextInput::make('plate_number')->label('رقم اللوحة')->maxLength(255),
                        TextInput::make('color')->label('اللون')->maxLength(255),
                        TextInput::make('make_model')->label('الماركة / الموديل')->maxLength(255),
                        Select::make('public_status')
                            ->label('الحالة العامة')
                            ->options(CleanStreetsOptions::reportPublicStatuses())
                            ->required(),
                        Select::make('internal_status')
                            ->label('الحالة الداخلية')
                            ->options(CleanStreetsOptions::reportInternalStatuses())
                            ->required(),
                        Textarea::make('review_note')
                            ->label('ملاحظة المراجعة')
                            ->rows(3)
                            ->columnSpanFull(),
                        DateTimePicker::make('submitted_at')->label('تاريخ الإرسال'),
                        DateTimePicker::make('reviewed_at')->label('تاريخ المراجعة'),
                        DateTimePicker::make('closed_at')->label('تاريخ الإغلاق'),
                    ])
                    ->columns(2),
            ]);
    }
}
