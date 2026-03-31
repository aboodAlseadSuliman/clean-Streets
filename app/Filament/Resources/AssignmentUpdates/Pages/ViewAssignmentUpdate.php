<?php

namespace App\Filament\Resources\AssignmentUpdates\Pages;

use App\Filament\Resources\AssignmentUpdates\AssignmentUpdateResource;
use Filament\Actions\EditAction;
use Filament\Resources\Pages\ViewRecord;

class ViewAssignmentUpdate extends ViewRecord
{
    protected static string $resource = AssignmentUpdateResource::class;

    protected function getHeaderActions(): array
    {
        return [
            EditAction::make(),
        ];
    }
}
