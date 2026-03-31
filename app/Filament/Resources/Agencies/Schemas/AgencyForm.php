<?php

namespace App\Filament\Resources\Agencies\Schemas;

use App\Support\CleanStreetsOptions;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;

class AgencyForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make('بيانات الجهة')
                    ->schema([
                        TextInput::make('name')
                            ->label('اسم الجهة')
                            ->required()
                            ->maxLength(255),
                        Select::make('type')
                            ->label('نوع الجهة')
                            ->options(CleanStreetsOptions::agencyTypes())
                            ->searchable()
                            ->required(),
                        TextInput::make('phone')
                            ->label('الهاتف')
                            ->tel()
                            ->maxLength(255),
                        TextInput::make('email')
                            ->label('البريد الإلكتروني')
                            ->email()
                            ->maxLength(255),
                        Textarea::make('address')
                            ->label('العنوان')
                            ->rows(3)
                            ->columnSpanFull(),
                        Toggle::make('is_active')
                            ->label('مفعلة')
                            ->default(true),
                    ])
                    ->columns(2),
            ]);
    }
}
