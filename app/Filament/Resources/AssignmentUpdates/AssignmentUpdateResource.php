<?php

namespace App\Filament\Resources\AssignmentUpdates;

use App\Filament\Resources\AssignmentUpdates\Pages\CreateAssignmentUpdate;
use App\Filament\Resources\AssignmentUpdates\Pages\EditAssignmentUpdate;
use App\Filament\Resources\AssignmentUpdates\Pages\ListAssignmentUpdates;
use App\Filament\Resources\AssignmentUpdates\Pages\ViewAssignmentUpdate;
use App\Filament\Resources\AssignmentUpdates\Schemas\AssignmentUpdateForm;
use App\Filament\Resources\AssignmentUpdates\Schemas\AssignmentUpdateInfolist;
use App\Filament\Resources\AssignmentUpdates\Tables\AssignmentUpdatesTable;
use App\Models\AssignmentUpdate;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;

class AssignmentUpdateResource extends Resource
{
    protected static ?string $model = AssignmentUpdate::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedRectangleStack;

    protected static ?string $recordTitleAttribute = 'update_type';

    protected static string|\UnitEnum|null $navigationGroup = 'الملفات والسجلات';

    protected static ?string $navigationLabel = 'تحديثات الإسناد';

    protected static ?string $modelLabel = 'تحديث إسناد';

    protected static ?string $pluralModelLabel = 'تحديثات الإسناد';

    protected static ?int $navigationSort = 3;

    public static function form(Schema $schema): Schema
    {
        return AssignmentUpdateForm::configure($schema);
    }

    public static function infolist(Schema $schema): Schema
    {
        return AssignmentUpdateInfolist::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return AssignmentUpdatesTable::configure($table);
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
            'index' => ListAssignmentUpdates::route('/'),
            'create' => CreateAssignmentUpdate::route('/create'),
            'view' => ViewAssignmentUpdate::route('/{record}'),
            'edit' => EditAssignmentUpdate::route('/{record}/edit'),
        ];
    }
}
