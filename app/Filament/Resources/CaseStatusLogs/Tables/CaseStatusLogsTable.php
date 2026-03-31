<?php

namespace App\Filament\Resources\CaseStatusLogs\Tables;

use App\Support\CleanStreetsOptions;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Actions\ViewAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Table;

class CaseStatusLogsTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('vehicleCase.case_number')->label('الحالة')->searchable()->sortable(),
                TextColumn::make('from_status')
                    ->label('من')
                    ->formatStateUsing(fn (?string $state): string => CleanStreetsOptions::caseStatuses()[$state] ?? (string) $state),
                TextColumn::make('to_status')
                    ->label('إلى')
                    ->badge()
                    ->formatStateUsing(fn (?string $state): string => CleanStreetsOptions::caseStatuses()[$state] ?? (string) $state),
                TextColumn::make('changedBy.name')->label('تم التغيير بواسطة')->searchable(),
                TextColumn::make('created_at')->label('التاريخ')->dateTime()->sortable(),
            ])
            ->filters([
                SelectFilter::make('to_status')
                    ->label('إلى حالة')
                    ->options(CleanStreetsOptions::caseStatuses()),
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
