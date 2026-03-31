<?php

namespace App\Filament\Resources\Inspections\Tables;

use App\Support\CleanStreetsOptions;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Actions\ViewAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Table;

class InspectionsTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('vehicleCase.case_number')->label('الحالة')->searchable()->sortable(),
                TextColumn::make('inspector.name')->label('المفتش')->searchable(),
                TextColumn::make('agency.name')->label('الجهة')->searchable(),
                TextColumn::make('inspection_result')
                    ->label('النتيجة')
                    ->badge()
                    ->formatStateUsing(fn (?string $state): string => CleanStreetsOptions::inspectionResults()[$state] ?? (string) $state),
                TextColumn::make('inspected_at')->label('وقت التحقق')->dateTime()->sortable(),
            ])
            ->filters([
                SelectFilter::make('inspection_result')
                    ->label('النتيجة')
                    ->options(CleanStreetsOptions::inspectionResults()),
                SelectFilter::make('agency_id')
                    ->label('الجهة')
                    ->relationship('agency', 'name')
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
            ->defaultSort('inspected_at', 'desc');
    }
}
