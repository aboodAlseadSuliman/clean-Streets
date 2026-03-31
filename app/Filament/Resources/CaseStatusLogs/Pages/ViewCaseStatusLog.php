<?php

namespace App\Filament\Resources\CaseStatusLogs\Pages;

use App\Filament\Resources\CaseStatusLogs\CaseStatusLogResource;
use Filament\Actions\EditAction;
use Filament\Resources\Pages\ViewRecord;

class ViewCaseStatusLog extends ViewRecord
{
    protected static string $resource = CaseStatusLogResource::class;

    protected function getHeaderActions(): array
    {
        return [
            EditAction::make(),
        ];
    }
}
