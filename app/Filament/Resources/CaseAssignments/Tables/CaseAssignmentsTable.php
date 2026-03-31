<?php

namespace App\Filament\Resources\CaseAssignments\Tables;

use App\Support\CleanStreetsOptions;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Actions\ViewAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Table;

class CaseAssignmentsTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('vehicleCase.case_number')->label('الحالة')->searchable()->sortable(),
                TextColumn::make('agency.name')->label('الجهة')->searchable(),
                TextColumn::make('assignedTo.name')->label('المستخدم المكلف')->searchable(),
                TextColumn::make('assignment_status')
                    ->label('الحالة')
                    ->badge()
                    ->formatStateUsing(fn (?string $state): string => CleanStreetsOptions::assignmentStatuses()[$state] ?? (string) $state),
                TextColumn::make('assigned_at')->label('تاريخ الإسناد')->dateTime()->sortable(),
                TextColumn::make('due_at')->label('الموعد النهائي')->dateTime()->sortable(),
            ])
            ->filters([
                SelectFilter::make('agency_id')
                    ->label('الجهة')
                    ->relationship('agency', 'name')
                    ->searchable(),
                SelectFilter::make('assignment_status')
                    ->label('الحالة')
                    ->options(CleanStreetsOptions::assignmentStatuses()),
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
            ->defaultSort('assigned_at', 'desc');
    }
}
