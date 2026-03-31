<?php

namespace App\Filament\Resources\VehicleCases;

use App\Filament\Resources\VehicleCases\Pages\CreateVehicleCase;
use App\Filament\Resources\VehicleCases\Pages\EditVehicleCase;
use App\Filament\Resources\VehicleCases\Pages\ListVehicleCases;
use App\Filament\Resources\VehicleCases\Pages\ViewVehicleCase;
use App\Filament\Resources\VehicleCases\Schemas\VehicleCaseForm;
use App\Filament\Resources\VehicleCases\Schemas\VehicleCaseInfolist;
use App\Filament\Resources\VehicleCases\Tables\VehicleCasesTable;
use App\Models\VehicleCase;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;

class VehicleCaseResource extends Resource
{
    protected static ?string $model = VehicleCase::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedRectangleStack;

    protected static ?string $recordTitleAttribute = 'case_number';

    protected static string|\UnitEnum|null $navigationGroup = 'المتابعة الميدانية';

    protected static ?string $navigationLabel = 'الحالات';

    protected static ?string $modelLabel = 'حالة';

    protected static ?string $pluralModelLabel = 'الحالات';

    protected static ?int $navigationSort = 1;

    public static function form(Schema $schema): Schema
    {
        return VehicleCaseForm::configure($schema);
    }

    public static function infolist(Schema $schema): Schema
    {
        return VehicleCaseInfolist::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return VehicleCasesTable::configure($table);
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
            'index' => ListVehicleCases::route('/'),
            'create' => CreateVehicleCase::route('/create'),
            'view' => ViewVehicleCase::route('/{record}'),
            'edit' => EditVehicleCase::route('/{record}/edit'),
        ];
    }
}
