<?php

namespace App\Filament\Resources\CaseAttachments;

use App\Filament\Resources\CaseAttachments\Pages\CreateCaseAttachment;
use App\Filament\Resources\CaseAttachments\Pages\EditCaseAttachment;
use App\Filament\Resources\CaseAttachments\Pages\ListCaseAttachments;
use App\Filament\Resources\CaseAttachments\Pages\ViewCaseAttachment;
use App\Filament\Resources\CaseAttachments\Schemas\CaseAttachmentForm;
use App\Filament\Resources\CaseAttachments\Schemas\CaseAttachmentInfolist;
use App\Filament\Resources\CaseAttachments\Tables\CaseAttachmentsTable;
use App\Models\CaseAttachment;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;

class CaseAttachmentResource extends Resource
{
    protected static ?string $model = CaseAttachment::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedRectangleStack;

    protected static ?string $recordTitleAttribute = 'file_name';

    protected static string|\UnitEnum|null $navigationGroup = 'الملفات والسجلات';

    protected static ?string $navigationLabel = 'مرفقات الحالات';

    protected static ?string $modelLabel = 'مرفق حالة';

    protected static ?string $pluralModelLabel = 'مرفقات الحالات';

    protected static ?int $navigationSort = 2;

    public static function form(Schema $schema): Schema
    {
        return CaseAttachmentForm::configure($schema);
    }

    public static function infolist(Schema $schema): Schema
    {
        return CaseAttachmentInfolist::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return CaseAttachmentsTable::configure($table);
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
            'index' => ListCaseAttachments::route('/'),
            'create' => CreateCaseAttachment::route('/create'),
            'view' => ViewCaseAttachment::route('/{record}'),
            'edit' => EditCaseAttachment::route('/{record}/edit'),
        ];
    }
}
