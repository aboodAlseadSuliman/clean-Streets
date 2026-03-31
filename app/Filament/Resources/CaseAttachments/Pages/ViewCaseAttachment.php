<?php

namespace App\Filament\Resources\CaseAttachments\Pages;

use App\Filament\Resources\CaseAttachments\CaseAttachmentResource;
use Filament\Actions\EditAction;
use Filament\Resources\Pages\ViewRecord;

class ViewCaseAttachment extends ViewRecord
{
    protected static string $resource = CaseAttachmentResource::class;

    protected function getHeaderActions(): array
    {
        return [
            EditAction::make(),
        ];
    }
}
