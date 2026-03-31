<?php

namespace App\Filament\Resources\Neighborhoods\Schemas;

use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;

class NeighborhoodForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make('بيانات الحي')
                    ->schema([
                        Select::make('district_id')
                            ->label('المنطقة')
                            ->relationship('district', 'name')
                            ->searchable()
                            ->preload(),
                        TextInput::make('name')
                            ->label('اسم الحي')
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
