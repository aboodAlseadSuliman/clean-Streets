<?php

namespace App\Filament\Resources\CaseStatusLogs;

use App\Filament\Resources\CaseStatusLogs\Pages\CreateCaseStatusLog;
use App\Filament\Resources\CaseStatusLogs\Pages\EditCaseStatusLog;
use App\Filament\Resources\CaseStatusLogs\Pages\ListCaseStatusLogs;
use App\Filament\Resources\CaseStatusLogs\Pages\ViewCaseStatusLog;
use App\Filament\Resources\CaseStatusLogs\Schemas\CaseStatusLogForm;
use App\Filament\Resources\CaseStatusLogs\Schemas\CaseStatusLogInfolist;
use App\Filament\Resources\CaseStatusLogs\Tables\CaseStatusLogsTable;
use App\Models\CaseStatusLog;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;

class CaseStatusLogResource extends Resource
{
    protected static ?string $model = CaseStatusLog::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedRectangleStack;

    protected static ?string $recordTitleAttribute = 'to_status';

    protected static string|\UnitEnum|null $navigationGroup = 'الملفات والسجلات';

    protected static ?string $navigationLabel = 'سجل الحالات';

    protected static ?string $modelLabel = 'سجل حالة';

    protected static ?string $pluralModelLabel = 'سجل الحالات';

    protected static ?int $navigationSort = 4;

    public static function form(Schema $schema): Schema
    {
        return CaseStatusLogForm::configure($schema);
    }

    public static function infolist(Schema $schema): Schema
    {
        return CaseStatusLogInfolist::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return CaseStatusLogsTable::configure($table);
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
            'index' => ListCaseStatusLogs::route('/'),
            'create' => CreateCaseStatusLog::route('/create'),
            'view' => ViewCaseStatusLog::route('/{record}'),
            'edit' => EditCaseStatusLog::route('/{record}/edit'),
        ];
    }
}
