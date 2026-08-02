<?php

namespace App\Filament\Resources\UserAddresses\Pages;

use App\Filament\Resources\UserAddresses\UserAddressResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditUserAddress extends EditRecord
{
    protected static string $resource = UserAddressResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make()
                ->icon('heroicon-o-trash')
                ->modalHeading('Delete Address')
                ->modalDescription('Are you sure you want to delete this address? This action cannot be undone.')
                ->modalSubmitActionLabel('Yes, Delete'),
        ];
    }

    protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index');
    }

    protected function mutateFormDataBeforeSave(array $data): array
    {
        // If this address is set as default, update other addresses
        if (isset($data['is_default']) && $data['is_default']) {
            \App\Models\Address::where('user_id', $data['user_id'])
                ->where('id', '!=', $this->record->id)
                ->update(['is_default' => false]);
        }

        return $data;
    }
}
