<?php

namespace App\Filament\Resources\Reports\RelationManagers;

use App\Filament\Resources\ReportAttachments\ReportAttachmentResource;
use Filament\Actions\EditAction;
use Filament\Actions\ViewAction;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Tables\Columns\ImageColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

class AttachmentsRelationManager extends RelationManager
{
    protected static string $relationship = 'attachments';

    protected static ?string $relatedResource = ReportAttachmentResource::class;

    protected static ?string $title = 'صور البلاغ';

    public function table(Table $table): Table
    {
        return $table
            ->columns([
                ImageColumn::make('file_path')
                    ->label('المعاينة')
                    ->disk('public')
                    ->square(),
                TextColumn::make('file_name')
                    ->label('اسم الملف')
                    ->searchable(),
                TextColumn::make('mime_type')
                    ->label('النوع'),
                TextColumn::make('file_size')
                    ->label('الحجم'),
                TextColumn::make('created_at')
                    ->label('أنشئ')
                    ->dateTime()
                    ->sortable(),
            ])
            ->recordActions([
                ViewAction::make(),
                EditAction::make(),
            ]);
    }
}
