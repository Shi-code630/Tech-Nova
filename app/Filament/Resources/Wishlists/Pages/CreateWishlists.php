<?php

namespace App\Filament\Resources\Wishlists\Pages;

use App\Filament\Resources\Wishlists\WishlistsResource;
use Filament\Resources\Pages\CreateRecord;

class CreateWishlists extends CreateRecord
{
    protected static string $resource = WishlistsResource::class;

    protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index');
    }
}
