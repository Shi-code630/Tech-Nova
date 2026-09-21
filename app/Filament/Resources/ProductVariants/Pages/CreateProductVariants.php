<?php

namespace App\Filament\Resources\ProductVariants\Pages;

use App\Filament\Resources\ProductVariants\ProductVariantsResource;
use Filament\Resources\Pages\CreateRecord;

class CreateProductVariants extends CreateRecord
{
    protected static string $resource = ProductVariantsResource::class;

    protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index');
    }

    protected function getCreatedNotificationTitle(): ?string
    {
        return 'Product variant created successfully!';
    }
}
