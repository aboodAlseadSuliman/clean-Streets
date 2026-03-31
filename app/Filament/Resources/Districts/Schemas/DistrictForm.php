<?php

namespace App\Filament\Resources\Districts\Schemas;

use Filament\Forms\Components\TextInput;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;

class DistrictForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make('بيانات المنطقة')
                    ->schema([
                        TextInput::make('name')
                            ->label('اسم المنطقة')
                            ->required()
                            ->maxLength(255),
                        TextInput::make('code')
                            ->label('الرمز')
                            ->maxLength(255),
                    ])
                    ->columns(2),
            ]);
    }
}
