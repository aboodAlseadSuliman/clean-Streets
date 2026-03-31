<?php

namespace App\Filament\Resources\Removals\Pages;

use App\Filament\Resources\Removals\RemovalResource;
use Filament\Actions\EditAction;
use Filament\Resources\Pages\ViewRecord;

class ViewRemoval extends ViewRecord
{
    protected static string $resource = RemovalResource::class;

    protected function getHeaderActions(): array
    {
        return [
            EditAction::make(),
        ];
    }
}
