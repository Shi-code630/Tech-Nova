<?php

namespace App\Filament\Resources\Payments\Pages;

use App\Filament\Resources\Payments\PaymentsResource;
use Filament\Resources\Pages\CreateRecord;

class CreatePayments extends CreateRecord
{
    protected static string $resource = PaymentsResource::class;

    protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index');
    }

    protected function mutateFormDataBeforeCreate(array $data): array
    {
        // Auto-generate transaction ID if not provided
        if (empty($data['transaction_id'])) {
            $data['transaction_id'] = 'TXN-' . date('Ymd') . '-' . rand(1000, 9999);
        }
        return $data;
    }
}
