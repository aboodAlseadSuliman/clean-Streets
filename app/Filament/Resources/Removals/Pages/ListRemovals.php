<?php

namespace App\Filament\Resources\Removals\Pages;

use App\Filament\Resources\Removals\RemovalResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;

class ListRemovals extends ListRecords
{
    protected static string $resource = RemovalResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make(),
        ];
    }
}
