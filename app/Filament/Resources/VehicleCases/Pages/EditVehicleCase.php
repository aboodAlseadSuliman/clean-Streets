<?php

namespace App\Filament\Resources\VehicleCases\Pages;

use App\Filament\Resources\VehicleCases\VehicleCaseResource;
use Filament\Actions\DeleteAction;
use Filament\Actions\ViewAction;
use Filament\Resources\Pages\EditRecord;

class EditVehicleCase extends EditRecord
{
    protected static string $resource = VehicleCaseResource::class;

    protected function getHeaderActions(): array
    {
        return [
            ViewAction::make(),
            DeleteAction::make(),
        ];
    }
}
