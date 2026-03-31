<?php

namespace App\Filament\Resources\CaseAttachments\Pages;

use App\Filament\Resources\CaseAttachments\CaseAttachmentResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;

class ListCaseAttachments extends ListRecords
{
    protected static string $resource = CaseAttachmentResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make(),
        ];
    }
}
