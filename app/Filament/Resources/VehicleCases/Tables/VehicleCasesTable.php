<?php

namespace App\Filament\Resources\VehicleCases\Tables;

use App\Support\CleanStreetsOptions;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Actions\ViewAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Table;

class VehicleCasesTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('case_number')->label('رقم الحالة')->searchable()->sortable(),
                TextColumn::make('current_status')
                    ->label('الحالة')
                    ->badge()
                    ->formatStateUsing(fn (?string $state): string => CleanStreetsOptions::caseStatuses()[$state] ?? (string) $state),
                TextColumn::make('priority')
                    ->label('الأولوية')
                    ->badge()
                    ->formatStateUsing(fn (?string $state): string => CleanStreetsOptions::casePriorities()[$state] ?? (string) $state),
                TextColumn::make('owningAgency.name')->label('الجهة')->searchable(),
                TextColumn::make('neighborhood.name')->label('الحي')->searchable(),
                TextColumn::make('vehicle_type')
                    ->label('نوع السيارة')
                    ->formatStateUsing(fn (?string $state): string => CleanStreetsOptions::vehicleTypes()[$state] ?? (string) $state),
                TextColumn::make('reports_count')->label('عدد البلاغات')->sortable(),
                TextColumn::make('removed_at')->label('أزيلت في')->dateTime()->sortable(),
            ])
            ->filters([
                SelectFilter::make('current_status')->label('الحالة')->options(CleanStreetsOptions::caseStatuses()),
                SelectFilter::make('priority')->label('الأولوية')->options(CleanStreetsOptions::casePriorities()),
                SelectFilter::make('owning_agency_id')
                    ->label('الجهة')
                    ->relationship('owningAgency', 'name')
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
            ->defaultSort('created_at', 'desc');
    }
}
