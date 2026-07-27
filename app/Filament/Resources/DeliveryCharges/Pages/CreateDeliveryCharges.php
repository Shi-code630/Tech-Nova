<?php

namespace App\Filament\Resources\DeliveryCharges\Pages;

use App\Filament\Resources\DeliveryChargesResource;
use Filament\Resources\Pages\CreateRecord;

class CreateDeliveryCharges extends CreateRecord
{
    protected static string $resource = DeliveryChargesResource::class;

    protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index');
    }
}
