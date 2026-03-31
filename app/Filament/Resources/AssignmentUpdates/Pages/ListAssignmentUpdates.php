<?php

namespace App\Filament\Resources\AssignmentUpdates\Pages;

use App\Filament\Resources\AssignmentUpdates\AssignmentUpdateResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;

class ListAssignmentUpdates extends ListRecords
{
    protected static string $resource = AssignmentUpdateResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make(),
        ];
    }
}
