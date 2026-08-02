<?php

namespace App\Filament\Resources\Brands\Pages;

use App\Filament\Resources\Brands\BrandsResource;
use Filament\Resources\Pages\CreateRecord;

class CreateBrands extends CreateRecord
{
    protected static string $resource = BrandsResource::class;

    protected function getRedirectUrl(): string
    {
        // Redirect to the index page after successful creation
        return $this->getResource()::getUrl('index');
    }

    // Optionally mutate data before saving (e.g., sanitize slug)
    // protected function mutateFormDataBeforeCreate(array $data): array
    // {
    //     $data['slug'] = \Illuminate\Support\Str::slug($data['slug'] ?? $data['name']);
    //     return $data;
    // }
}
