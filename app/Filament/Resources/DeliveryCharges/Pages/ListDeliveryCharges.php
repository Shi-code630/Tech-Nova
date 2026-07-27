<?php

namespace App\Filament\Resources\DeliveryCharges\Pages;

use App\Filament\Resources\DeliveryChargesResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;

class ListDeliveryCharges extends ListRecords
{
    protected static string $resource = DeliveryChargesResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make()
                ->label('New Delivery Charge')
                ->icon('heroicon-o-plus'),
        ];
    }
}
