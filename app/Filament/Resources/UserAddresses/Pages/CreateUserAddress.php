<?php

namespace App\Filament\Resources\UserAddresses\Pages;

use App\Filament\Resources\UserAddresses\UserAddressResource;
use Filament\Resources\Pages\CreateRecord;

class CreateUserAddress extends CreateRecord
{
    protected static string $resource = UserAddressResource::class;

    protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index');
    }

    protected function mutateFormDataBeforeCreate(array $data): array
    {
        // If this address is set as default, update other addresses
        if (isset($data['is_default']) && $data['is_default']) {
            \App\Models\Address::where('user_id', $data['user_id'])
                ->update(['is_default' => false]);
        }

        return $data;
    }
}
