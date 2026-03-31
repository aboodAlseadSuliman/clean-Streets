<?php

namespace App\Filament\Resources\ReportAttachments;

use App\Filament\Resources\ReportAttachments\Pages\CreateReportAttachment;
use App\Filament\Resources\ReportAttachments\Pages\EditReportAttachment;
use App\Filament\Resources\ReportAttachments\Pages\ListReportAttachments;
use App\Filament\Resources\ReportAttachments\Pages\ViewReportAttachment;
use App\Filament\Resources\ReportAttachments\Schemas\ReportAttachmentForm;
use App\Filament\Resources\ReportAttachments\Schemas\ReportAttachmentInfolist;
use App\Filament\Resources\ReportAttachments\Tables\ReportAttachmentsTable;
use App\Models\ReportAttachment;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;

class ReportAttachmentResource extends Resource
{
    protected static ?string $model = ReportAttachment::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedRectangleStack;

    protected static ?string $recordTitleAttribute = 'file_name';

    protected static string|\UnitEnum|null $navigationGroup = 'الملفات والسجلات';

    protected static ?string $navigationLabel = 'مرفقات البلاغات';

    protected static ?string $modelLabel = 'مرفق بلاغ';

    protected static ?string $pluralModelLabel = 'مرفقات البلاغات';

    protected static ?int $navigationSort = 1;

    public static function form(Schema $schema): Schema
    {
        return ReportAttachmentForm::configure($schema);
    }

    public static function infolist(Schema $schema): Schema
    {
        return ReportAttachmentInfolist::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return ReportAttachmentsTable::configure($table);
    }

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => ListReportAttachments::route('/'),
            'create' => CreateReportAttachment::route('/create'),
            'view' => ViewReportAttachment::route('/{record}'),
            'edit' => EditReportAttachment::route('/{record}/edit'),
        ];
    }
}
