<?php

namespace App\Filament\Resources\AssignmentUpdates\Pages;

use App\Filament\Resources\AssignmentUpdates\AssignmentUpdateResource;
use Filament\Actions\DeleteAction;
use Filament\Actions\ViewAction;
use Filament\Resources\Pages\EditRecord;

class EditAssignmentUpdate extends EditRecord
{
    protected static string $resource = AssignmentUpdateResource::class;

    protected function getHeaderActions(): array
    {
        return [
            ViewAction::make(),
            DeleteAction::make(),
        ];
    }
}
