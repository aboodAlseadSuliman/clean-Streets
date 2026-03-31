<?php

namespace App\Filament\Resources\ReportAttachments\Pages;

use App\Filament\Resources\ReportAttachments\ReportAttachmentResource;
use Filament\Actions\EditAction;
use Filament\Resources\Pages\ViewRecord;

class ViewReportAttachment extends ViewRecord
{
    protected static string $resource = ReportAttachmentResource::class;

    protected function getHeaderActions(): array
    {
        return [
            EditAction::make(),
        ];
    }
}
