<?php

namespace App\Filament\Resources\Categories\Pages;

use App\Filament\Resources\Categories\CategoriesResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;

class ListCategories extends ListRecords
{
    protected static string $resource = CategoriesResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make()
                ->label('New Category')
                ->icon('heroicon-o-plus'),
        ];
    }

    protected function getDefaultTableSortColumn(): ?string
    {
        return 'name';
    }

    protected function getDefaultTableSortDirection(): ?string
    {
        return 'asc';
    }
}
