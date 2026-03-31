<?php

namespace App\Filament\Resources\CaseAttachments\Pages;

use App\Filament\Resources\CaseAttachments\CaseAttachmentResource;
use Filament\Actions\DeleteAction;
use Filament\Actions\ViewAction;
use Filament\Resources\Pages\EditRecord;

class EditCaseAttachment extends EditRecord
{
    protected static string $resource = CaseAttachmentResource::class;

    protected function getHeaderActions(): array
    {
        return [
            ViewAction::make(),
            DeleteAction::make(),
        ];
    }
}
