<?php

namespace App\Filament\Resources\Wishlists\Pages;

use App\Filament\Resources\Wishlists\WishlistsResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;

class ListWishlists extends ListRecords
{
    protected static string $resource = WishlistsResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make(),
        ];
    }
}
