<?php

namespace App\Filament\Resources\CaseAttachments\Tables;

use App\Support\CleanStreetsOptions;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Actions\ViewAction;
use Filament\Tables\Columns\ImageColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Table;

class CaseAttachmentsTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                ImageColumn::make('public_url')
                    ->label('المعاينة')
                    ->square(),
                TextColumn::make('vehicleCase.case_number')->label('الحالة')->searchable()->sortable(),
                TextColumn::make('category')
                    ->label('الفئة')
                    ->badge()
                    ->formatStateUsing(fn (?string $state): string => CleanStreetsOptions::attachmentCategories()[$state] ?? (string) $state),
                TextColumn::make('file_name')->label('اسم الملف')->searchable(),
                TextColumn::make('uploadedBy.name')->label('رفع بواسطة')->searchable(),
                TextColumn::make('created_at')->label('أنشئ')->dateTime()->sortable(),
            ])
            ->filters([
                SelectFilter::make('category')
                    ->label('الفئة')
                    ->options(CleanStreetsOptions::attachmentCategories()),
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
