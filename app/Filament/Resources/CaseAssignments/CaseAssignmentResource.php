<?php

namespace App\Filament\Resources\CaseAssignments;

use App\Filament\Resources\CaseAssignments\Pages\CreateCaseAssignment;
use App\Filament\Resources\CaseAssignments\Pages\EditCaseAssignment;
use App\Filament\Resources\CaseAssignments\Pages\ListCaseAssignments;
use App\Filament\Resources\CaseAssignments\Pages\ViewCaseAssignment;
use App\Filament\Resources\CaseAssignments\Schemas\CaseAssignmentForm;
use App\Filament\Resources\CaseAssignments\Schemas\CaseAssignmentInfolist;
use App\Filament\Resources\CaseAssignments\Tables\CaseAssignmentsTable;
use App\Models\CaseAssignment;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;

class CaseAssignmentResource extends Resource
{
    protected static ?string $model = CaseAssignment::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedRectangleStack;

    protected static ?string $recordTitleAttribute = 'assignment_status';

    protected static string|\UnitEnum|null $navigationGroup = 'المتابعة الميدانية';

    protected static ?string $navigationLabel = 'الإسنادات';

    protected static ?string $modelLabel = 'إسناد';

    protected static ?string $pluralModelLabel = 'الإسنادات';

    protected static ?int $navigationSort = 3;

    public static function form(Schema $schema): Schema
    {
        return CaseAssignmentForm::configure($schema);
    }

    public static function infolist(Schema $schema): Schema
    {
        return CaseAssignmentInfolist::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return CaseAssignmentsTable::configure($table);
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
            'index' => ListCaseAssignments::route('/'),
            'create' => CreateCaseAssignment::route('/create'),
            'view' => ViewCaseAssignment::route('/{record}'),
            'edit' => EditCaseAssignment::route('/{record}/edit'),
        ];
    }
}
