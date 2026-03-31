<?php

namespace App\Filament\Resources\ReportAttachments\Tables;

use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Actions\ViewAction;
use Filament\Tables\Columns\ImageColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

class ReportAttachmentsTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                ImageColumn::make('public_url')
                    ->label('المعاينة')
                    ->square(),
                TextColumn::make('report.tracking_code')->label('البلاغ')->searchable()->sortable(),
                TextColumn::make('file_name')->label('اسم الملف')->searchable(),
                TextColumn::make('mime_type')->label('نوع الملف'),
                TextColumn::make('file_size')->label('الحجم'),
                TextColumn::make('created_at')->label('أنشئ')->dateTime()->sortable(),
            ])
            ->filters([
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
