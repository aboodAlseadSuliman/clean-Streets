<?php

namespace App\Filament\Resources\VehicleCases\Schemas;

use App\Support\CleanStreetsOptions;
use Filament\Forms\Components\DateTimePicker;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;

class VehicleCaseForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make('بيانات الحالة')
                    ->schema([
                        TextInput::make('case_number')
                            ->label('رقم الحالة')
                            ->required()
                            ->unique(ignoreRecord: true)
                            ->maxLength(255),
                        Select::make('source_report_id')
                            ->label('البلاغ الأساسي')
                            ->relationship('sourceReport', 'tracking_code')
                            ->searchable()
                            ->preload(),
                        Select::make('owning_agency_id')
                            ->label('الجهة المالكة')
                            ->relationship('owningAgency', 'name')
                            ->searchable()
                            ->preload(),
                        Select::make('created_by_user_id')
                            ->label('أنشأها المستخدم')
                            ->relationship('creator', 'name')
                            ->searchable()
                            ->preload(),
                        Select::make('priority')
                            ->label('الأولوية')
                            ->options(CleanStreetsOptions::casePriorities())
                            ->required(),
                        Select::make('current_status')
                            ->label('الحالة الحالية')
                            ->options(CleanStreetsOptions::caseStatuses())
                            ->required(),
                        TextInput::make('reports_count')
                            ->label('عدد البلاغات')
                            ->numeric()
                            ->default(0),
                    ])
                    ->columns(2),
                Section::make('الموقع')
                    ->schema([
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
                        Textarea::make('location_text')
                            ->label('وصف الموقع')
                            ->required()
                            ->rows(3)
                            ->columnSpanFull(),
                        TextInput::make('nearest_landmark')->label('أقرب معلم')->maxLength(255),
                        TextInput::make('google_maps_url')
                            ->label('رابط Google Maps')
                            ->url()
                            ->maxLength(65535)
                            ->columnSpanFull(),
                        TextInput::make('latitude')->label('Latitude')->numeric(),
                        TextInput::make('longitude')->label('Longitude')->numeric(),
                    ])
                    ->columns(2),
                Section::make('وصف السيارة')
                    ->schema([
                        Select::make('vehicle_type')
                            ->label('نوع السيارة')
                            ->options(CleanStreetsOptions::vehicleTypes())
                            ->required(),
                        Select::make('damage_type')
                            ->label('نوع الضرر')
                            ->options(CleanStreetsOptions::damageTypes())
                            ->required(),
                        TextInput::make('plate_number')->label('رقم اللوحة')->maxLength(255),
                        TextInput::make('color')->label('اللون')->maxLength(255),
                        TextInput::make('make_model')->label('الماركة / الموديل')->maxLength(255),
                        DateTimePicker::make('first_reported_at')->label('أول بلاغ'),
                        DateTimePicker::make('last_reported_at')->label('آخر بلاغ'),
                        DateTimePicker::make('verified_at')->label('تاريخ التحقق'),
                        DateTimePicker::make('removed_at')->label('تاريخ الإزالة'),
                        DateTimePicker::make('closed_at')->label('تاريخ الإغلاق'),
                    ])
                    ->columns(2),
            ]);
    }
}
