<?php

namespace App\Filament\Resources\ReportAttachments\Pages;

use App\Filament\Resources\ReportAttachments\ReportAttachmentResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;

class ListReportAttachments extends ListRecords
{
    protected static string $resource = ReportAttachmentResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make(),
        ];
    }
}
