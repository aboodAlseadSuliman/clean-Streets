<?php

namespace App\Filament\Resources\CaseStatusLogs\Pages;

use App\Filament\Resources\CaseStatusLogs\CaseStatusLogResource;
use Filament\Actions\DeleteAction;
use Filament\Actions\ViewAction;
use Filament\Resources\Pages\EditRecord;

class EditCaseStatusLog extends EditRecord
{
    protected static string $resource = CaseStatusLogResource::class;

    protected function getHeaderActions(): array
    {
        return [
            ViewAction::make(),
            DeleteAction::make(),
        ];
    }
}
