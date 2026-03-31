<?php

namespace App\Filament\Resources\Reports\Pages;

use App\Filament\Resources\Reports\ReportResource;
use App\Filament\Resources\Reports\Pages\Concerns\HasReportWorkflowActions;
use Filament\Actions\DeleteAction;
use Filament\Actions\ViewAction;
use Filament\Resources\Pages\EditRecord;

class EditReport extends EditRecord
{
    use HasReportWorkflowActions;

    protected static string $resource = ReportResource::class;

    protected function getHeaderActions(): array
    {
        return [
            ...$this->getReportWorkflowActions(),
            ViewAction::make(),
            DeleteAction::make(),
        ];
    }
}
