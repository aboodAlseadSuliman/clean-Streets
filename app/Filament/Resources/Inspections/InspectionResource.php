<?php

namespace App\Filament\Resources\Inspections;

use App\Filament\Resources\Inspections\Pages\CreateInspection;
use App\Filament\Resources\Inspections\Pages\EditInspection;
use App\Filament\Resources\Inspections\Pages\ListInspections;
use App\Filament\Resources\Inspections\Pages\ViewInspection;
use App\Filament\Resources\Inspections\Schemas\InspectionForm;
use App\Filament\Resources\Inspections\Schemas\InspectionInfolist;
use App\Filament\Resources\Inspections\Tables\InspectionsTable;
use App\Models\Inspection;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;

class InspectionResource extends Resource
{
    protected static ?string $model = Inspection::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedRectangleStack;

    protected static ?string $recordTitleAttribute = 'inspection_result';

    protected static string|\UnitEnum|null $navigationGroup = 'المتابعة الميدانية';

    protected static ?string $navigationLabel = 'عمليات التحقق';

    protected static ?string $modelLabel = 'تحقق';

    protected static ?string $pluralModelLabel = 'عمليات التحقق';

    protected static ?int $navigationSort = 2;

    public static function form(Schema $schema): Schema
    {
        return InspectionForm::configure($schema);
    }

    public static function infolist(Schema $schema): Schema
    {
        return InspectionInfolist::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return InspectionsTable::configure($table);
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
            'index' => ListInspections::route('/'),
            'create' => CreateInspection::route('/create'),
            'view' => ViewInspection::route('/{record}'),
            'edit' => EditInspection::route('/{record}/edit'),
        ];
    }
}
