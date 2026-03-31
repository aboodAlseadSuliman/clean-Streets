<?php

namespace App\Filament\Resources\Citizens;

use App\Filament\Resources\Citizens\Pages\CreateCitizen;
use App\Filament\Resources\Citizens\Pages\EditCitizen;
use App\Filament\Resources\Citizens\Pages\ListCitizens;
use App\Filament\Resources\Citizens\Pages\ViewCitizen;
use App\Filament\Resources\Citizens\Schemas\CitizenForm;
use App\Filament\Resources\Citizens\Schemas\CitizenInfolist;
use App\Filament\Resources\Citizens\Tables\CitizensTable;
use App\Models\Citizen;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;

class CitizenResource extends Resource
{
    protected static ?string $model = Citizen::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedRectangleStack;

    protected static ?string $recordTitleAttribute = 'full_name';

    protected static string|\UnitEnum|null $navigationGroup = 'المواطنون والبلاغات';

    protected static ?string $navigationLabel = 'المواطنون';

    protected static ?string $modelLabel = 'مواطن';

    protected static ?string $pluralModelLabel = 'المواطنون';

    protected static ?int $navigationSort = 1;

    public static function form(Schema $schema): Schema
    {
        return CitizenForm::configure($schema);
    }

    public static function infolist(Schema $schema): Schema
    {
        return CitizenInfolist::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return CitizensTable::configure($table);
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
            'index' => ListCitizens::route('/'),
            'create' => CreateCitizen::route('/create'),
            'view' => ViewCitizen::route('/{record}'),
            'edit' => EditCitizen::route('/{record}/edit'),
        ];
    }
}
