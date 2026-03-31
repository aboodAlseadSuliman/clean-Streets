<?php

namespace App\Filament\Resources\Neighborhoods\Tables;

use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Actions\ViewAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Table;

class NeighborhoodsTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('name')->label('اسم الحي')->searchable()->sortable(),
                TextColumn::make('district.name')->label('المنطقة')->searchable()->sortable(),
                TextColumn::make('code')->label('الرمز')->searchable(),
                TextColumn::make('created_at')->label('أنشئ')->dateTime()->sortable(),
            ])
            ->filters([
                SelectFilter::make('district_id')
                    ->label('المنطقة')
                    ->relationship('district', 'name')
                    ->searchable(),
            ])
            ->recordActions([
                ViewAction::make(),
                EditAction::make(),
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                ]),
            ])
            ->defaultSort('name');
    }
}
