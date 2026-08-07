<?php

namespace App\Filament\Resources\ShoppingCarts\Pages;

use App\Filament\Resources\ShoppingCarts\ShoppingCartsResource;
use Filament\Resources\Pages\CreateRecord;

class CreateShoppingCarts extends CreateRecord
{
    protected static string $resource = ShoppingCartsResource::class;

    protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index');
    }
}
