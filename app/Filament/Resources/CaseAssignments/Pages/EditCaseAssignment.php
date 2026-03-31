<?php

namespace App\Filament\Resources\CaseAssignments\Pages;

use App\Filament\Resources\CaseAssignments\CaseAssignmentResource;
use Filament\Actions\DeleteAction;
use Filament\Actions\ViewAction;
use Filament\Resources\Pages\EditRecord;

class EditCaseAssignment extends EditRecord
{
    protected static string $resource = CaseAssignmentResource::class;

    protected function getHeaderActions(): array
    {
        return [
            ViewAction::make(),
            DeleteAction::make(),
        ];
    }
}
