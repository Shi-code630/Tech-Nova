<?php

namespace App\Filament\Resources\ShoppingCarts\Pages;

use App\Filament\Resources\ShoppingCarts\ShoppingCartsResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;

class ListShoppingCarts extends ListRecords
{
    protected static string $resource = ShoppingCartsResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make(),
        ];
    }
}
