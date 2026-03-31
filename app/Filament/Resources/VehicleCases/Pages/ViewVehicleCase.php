<?php

namespace App\Filament\Resources\VehicleCases\Pages;

use App\Filament\Resources\VehicleCases\VehicleCaseResource;
use Filament\Actions\EditAction;
use Filament\Resources\Pages\ViewRecord;

class ViewVehicleCase extends ViewRecord
{
    protected static string $resource = VehicleCaseResource::class;

    protected function getHeaderActions(): array
    {
        return [
            EditAction::make(),
        ];
    }
}
