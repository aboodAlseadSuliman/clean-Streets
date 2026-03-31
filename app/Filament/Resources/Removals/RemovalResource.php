<?php

namespace App\Filament\Resources\Removals;

use App\Filament\Resources\Removals\Pages\CreateRemoval;
use App\Filament\Resources\Removals\Pages\EditRemoval;
use App\Filament\Resources\Removals\Pages\ListRemovals;
use App\Filament\Resources\Removals\Pages\ViewRemoval;
use App\Filament\Resources\Removals\Schemas\RemovalForm;
use App\Filament\Resources\Removals\Schemas\RemovalInfolist;
use App\Filament\Resources\Removals\Tables\RemovalsTable;
use App\Models\Removal;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;

class RemovalResource extends Resource
{
    protected static ?string $model = Removal::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedRectangleStack;

    protected static ?string $recordTitleAttribute = 'result';

    protected static string|\UnitEnum|null $navigationGroup = 'المتابعة الميدانية';

    protected static ?string $navigationLabel = 'عمليات الإزالة';

    protected static ?string $modelLabel = 'إزالة';

    protected static ?string $pluralModelLabel = 'عمليات الإزالة';

    protected static ?int $navigationSort = 4;

    public static function form(Schema $schema): Schema
    {
        return RemovalForm::configure($schema);
    }

    public static function infolist(Schema $schema): Schema
    {
        return RemovalInfolist::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return RemovalsTable::configure($table);
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
            'index' => ListRemovals::route('/'),
            'create' => CreateRemoval::route('/create'),
            'view' => ViewRemoval::route('/{record}'),
            'edit' => EditRemoval::route('/{record}/edit'),
        ];
    }
}
