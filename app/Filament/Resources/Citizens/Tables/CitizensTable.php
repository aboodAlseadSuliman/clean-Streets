<?php

namespace App\Filament\Resources\Citizens\Tables;

use App\Support\CleanStreetsOptions;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Actions\ViewAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Table;

class CitizensTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('full_name')->label('الاسم الكامل')->searchable()->sortable(),
                TextColumn::make('phone')->label('الهاتف')->searchable(),
                TextColumn::make('whatsapp_phone')->label('واتساب')->searchable(),
                TextColumn::make('email')->label('البريد الإلكتروني')->searchable(),
                TextColumn::make('preferred_contact_method')
                    ->label('وسيلة التواصل')
                    ->badge()
                    ->formatStateUsing(fn (?string $state): string => CleanStreetsOptions::contactMethods()[$state] ?? (string) $state),
                TextColumn::make('created_at')->label('أنشئ')->dateTime()->sortable(),
            ])
            ->filters([
                SelectFilter::make('preferred_contact_method')
                    ->label('وسيلة التواصل')
                    ->options(CleanStreetsOptions::contactMethods()),
            ])
            ->recordActions([
                ViewAction::make(),
                EditAction::make(),
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                ]),
            ])
            ->defaultSort('full_name');
    }
}
