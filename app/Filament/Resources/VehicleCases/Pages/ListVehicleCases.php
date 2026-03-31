<?php

namespace App\Filament\Resources\VehicleCases\Pages;

use App\Filament\Resources\VehicleCases\VehicleCaseResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;

class ListVehicleCases extends ListRecords
{
    protected static string $resource = VehicleCaseResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make(),
        ];
    }
}
