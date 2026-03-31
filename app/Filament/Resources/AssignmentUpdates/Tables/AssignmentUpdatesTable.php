<?php

namespace App\Filament\Resources\AssignmentUpdates\Tables;

use App\Support\CleanStreetsOptions;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Actions\ViewAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Table;

class AssignmentUpdatesTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('caseAssignment.id')->label('الإسناد')->sortable(),
                TextColumn::make('agency.name')->label('الجهة')->searchable(),
                TextColumn::make('user.name')->label('المستخدم')->searchable(),
                TextColumn::make('update_type')
                    ->label('نوع التحديث')
                    ->badge()
                    ->formatStateUsing(fn (?string $state): string => CleanStreetsOptions::assignmentUpdateTypes()[$state] ?? (string) $state),
                TextColumn::make('created_at')->label('أنشئ')->dateTime()->sortable(),
            ])
            ->filters([
                SelectFilter::make('update_type')
                    ->label('نوع التحديث')
                    ->options(CleanStreetsOptions::assignmentUpdateTypes()),
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
