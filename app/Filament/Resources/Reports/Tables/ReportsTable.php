<?php

namespace App\Filament\Resources\Reports\Tables;

use App\Support\CleanStreetsOptions;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Actions\ViewAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Table;

class ReportsTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('tracking_code')->label('رمز التتبع')->searchable()->sortable(),
                TextColumn::make('citizen.full_name')->label('المواطن')->searchable()->sortable(),
                TextColumn::make('vehicleCase.case_number')->label('الحالة')->searchable(),
                TextColumn::make('request_type')
                    ->label('نوع الطلب')
                    ->badge()
                    ->formatStateUsing(fn (?string $state): string => CleanStreetsOptions::requestTypes()[$state] ?? (string) $state),
                TextColumn::make('public_status')
                    ->label('الحالة العامة')
                    ->badge()
                    ->formatStateUsing(fn (?string $state): string => CleanStreetsOptions::reportPublicStatuses()[$state] ?? (string) $state),
                TextColumn::make('internal_status')
                    ->label('الحالة الداخلية')
                    ->badge()
                    ->formatStateUsing(fn (?string $state): string => CleanStreetsOptions::reportInternalStatuses()[$state] ?? (string) $state),
                TextColumn::make('neighborhood.name')->label('الحي')->searchable(),
                TextColumn::make('submitted_at')->label('تاريخ الإرسال')->dateTime()->sortable(),
            ])
            ->filters([
                SelectFilter::make('request_type')->label('نوع الطلب')->options(CleanStreetsOptions::requestTypes()),
                SelectFilter::make('public_status')->label('الحالة العامة')->options(CleanStreetsOptions::reportPublicStatuses()),
                SelectFilter::make('internal_status')->label('الحالة الداخلية')->options(CleanStreetsOptions::reportInternalStatuses()),
                SelectFilter::make('district_id')
                    ->label('المنطقة')
                    ->relationship('district', 'name')
                    ->searchable(),
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
            ->defaultSort('submitted_at', 'desc');
    }
}
