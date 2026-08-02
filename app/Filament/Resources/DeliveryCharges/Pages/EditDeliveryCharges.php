<?php

namespace App\Filament\Resources\DeliveryCharges\Pages;

use App\Filament\Resources\DeliveryCharges\DeliveryChargesResource;
use Filament\Actions\DeleteAction;
use Filament\Resources\Pages\EditRecord;

class EditDeliveryCharges extends EditRecord
{
    protected static string $resource = DeliveryChargesResource::class;

    protected function getHeaderActions(): array
    {
        return [
            DeleteAction::make(),
        ];
    }

    protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index');
    }
}
