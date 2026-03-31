<?php

namespace App\Filament\Resources\CaseStatusLogs\Pages;

use App\Filament\Resources\CaseStatusLogs\CaseStatusLogResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;

class ListCaseStatusLogs extends ListRecords
{
    protected static string $resource = CaseStatusLogResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make(),
        ];
    }
}
