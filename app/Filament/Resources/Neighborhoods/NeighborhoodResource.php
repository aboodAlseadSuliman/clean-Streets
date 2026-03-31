<?php

namespace App\Filament\Resources\Neighborhoods;

use App\Filament\Resources\Neighborhoods\Pages\CreateNeighborhood;
use App\Filament\Resources\Neighborhoods\Pages\EditNeighborhood;
use App\Filament\Resources\Neighborhoods\Pages\ListNeighborhoods;
use App\Filament\Resources\Neighborhoods\Pages\ViewNeighborhood;
use App\Filament\Resources\Neighborhoods\Schemas\NeighborhoodForm;
use App\Filament\Resources\Neighborhoods\Schemas\NeighborhoodInfolist;
use App\Filament\Resources\Neighborhoods\Tables\NeighborhoodsTable;
use App\Models\Neighborhood;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;

class NeighborhoodResource extends Resource
{
    protected static ?string $model = Neighborhood::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedRectangleStack;

    protected static ?string $recordTitleAttribute = 'name';

    protected static string|\UnitEnum|null $navigationGroup = 'الإعدادات';

    protected static ?string $navigationLabel = 'الأحياء';

    protected static ?string $modelLabel = 'حي';

    protected static ?string $pluralModelLabel = 'الأحياء';

    protected static ?int $navigationSort = 4;

    public static function form(Schema $schema): Schema
    {
        return NeighborhoodForm::configure($schema);
    }

    public static function infolist(Schema $schema): Schema
    {
        return NeighborhoodInfolist::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return NeighborhoodsTable::configure($table);
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
            'index' => ListNeighborhoods::route('/'),
            'create' => CreateNeighborhood::route('/create'),
            'view' => ViewNeighborhood::route('/{record}'),
            'edit' => EditNeighborhood::route('/{record}/edit'),
        ];
    }
}
