<?php

namespace App\Filament\Resources\Citizens\Schemas;

use App\Support\CleanStreetsOptions;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;

class CitizenForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make('بيانات المواطن')
                    ->schema([
                        TextInput::make('full_name')
                            ->label('الاسم الكامل')
                            ->required()
                            ->maxLength(255),
                        TextInput::make('phone')
                            ->label('الهاتف')
                            ->required()
                            ->tel()
                            ->maxLength(255),
                        TextInput::make('whatsapp_phone')
                            ->label('واتساب')
                            ->tel()
                            ->maxLength(255),
                        TextInput::make('email')
                            ->label('البريد الإلكتروني')
                            ->email()
                            ->maxLength(255),
                        Select::make('preferred_contact_method')
                            ->label('وسيلة التواصل المفضلة')
                            ->options(CleanStreetsOptions::contactMethods())
                            ->searchable(),
                        Textarea::make('notes')
                            ->label('ملاحظات')
                            ->rows(3)
                            ->columnSpanFull(),
                    ])
                    ->columns(2),
            ]);
    }
}
