<?php

namespace App\Filament\Resources\Users\Tables;

use App\Support\CleanStreetsOptions;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Actions\ViewAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Table;

class UsersTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('name')->label('الاسم')->searchable()->sortable(),
                TextColumn::make('email')->label('البريد الإلكتروني')->searchable()->sortable(),
                TextColumn::make('agency.name')->label('الجهة')->searchable()->sortable(),
                TextColumn::make('role')
                    ->label('الدور')
                    ->badge()
                    ->formatStateUsing(fn (?string $state): string => CleanStreetsOptions::userRoles()[$state] ?? (string) $state),
                TextColumn::make('is_active')
                    ->label('الحالة')
                    ->badge()
                    ->formatStateUsing(fn (bool $state): string => $state ? 'نشط' : 'موقوف')
                    ->color(fn (bool $state): string => $state ? 'success' : 'danger'),
                TextColumn::make('created_at')->label('أنشئ')->dateTime()->sortable(),
            ])
            ->filters([
                SelectFilter::make('agency_id')
                    ->label('الجهة')
                    ->relationship('agency', 'name')
                    ->searchable(),
                SelectFilter::make('role')
                    ->label('الدور')
                    ->options(CleanStreetsOptions::userRoles()),
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
            ->defaultSort('name');
    }
}
