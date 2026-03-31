<?php

namespace App\Filament\Resources\Reports\Pages;

use App\Filament\Resources\Reports\ReportResource;
use App\Filament\Resources\Reports\Pages\Concerns\HasReportWorkflowActions;
use Filament\Actions\EditAction;
use Filament\Resources\Pages\ViewRecord;

class ViewReport extends ViewRecord
{
    use HasReportWorkflowActions;

    protected static string $resource = ReportResource::class;

    protected function getHeaderActions(): array
    {
        return [
            ...$this->getReportWorkflowActions(),
            EditAction::make(),
        ];
    }
}
