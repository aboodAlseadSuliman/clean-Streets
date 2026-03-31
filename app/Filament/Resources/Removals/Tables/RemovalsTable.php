<?php

namespace App\Filament\Resources\Removals\Tables;

use App\Support\CleanStreetsOptions;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Actions\ViewAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Table;

class RemovalsTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('vehicleCase.case_number')->label('الحالة')->searchable()->sortable(),
                TextColumn::make('agency.name')->label('الجهة')->searchable(),
                TextColumn::make('executedBy.name')->label('نفذها')->searchable(),
                TextColumn::make('result')
                    ->label('النتيجة')
                    ->badge()
                    ->formatStateUsing(fn (?string $state): string => CleanStreetsOptions::removalResults()[$state] ?? (string) $state),
                TextColumn::make('destination')->label('الوجهة')->searchable(),
                TextColumn::make('completed_at')->label('تمت في')->dateTime()->sortable(),
            ])
            ->filters([
                SelectFilter::make('agency_id')
                    ->label('الجهة')
                    ->relationship('agency', 'name')
                    ->searchable(),
                SelectFilter::make('result')
                    ->label('النتيجة')
                    ->options(CleanStreetsOptions::removalResults()),
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
            ->defaultSort('completed_at', 'desc');
    }
}
