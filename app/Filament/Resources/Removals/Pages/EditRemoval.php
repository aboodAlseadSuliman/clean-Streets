<?php

namespace App\Filament\Resources\Removals\Pages;

use App\Filament\Resources\Removals\RemovalResource;
use Filament\Actions\DeleteAction;
use Filament\Actions\ViewAction;
use Filament\Resources\Pages\EditRecord;

class EditRemoval extends EditRecord
{
    protected static string $resource = RemovalResource::class;

    protected function getHeaderActions(): array
    {
        return [
            ViewAction::make(),
            DeleteAction::make(),
        ];
    }
}
