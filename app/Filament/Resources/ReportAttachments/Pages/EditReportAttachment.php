<?php

namespace App\Filament\Resources\ReportAttachments\Pages;

use App\Filament\Resources\ReportAttachments\ReportAttachmentResource;
use Filament\Actions\DeleteAction;
use Filament\Actions\ViewAction;
use Filament\Resources\Pages\EditRecord;

class EditReportAttachment extends EditRecord
{
    protected static string $resource = ReportAttachmentResource::class;

    protected function getHeaderActions(): array
    {
        return [
            ViewAction::make(),
            DeleteAction::make(),
        ];
    }
}
