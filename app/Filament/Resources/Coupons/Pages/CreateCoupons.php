<?php

namespace App\Filament\Resources\Coupons\Pages;

use App\Filament\Resources\Coupons\CouponsResource;
use Filament\Resources\Pages\CreateRecord;

class CreateCoupons extends CreateRecord
{
    protected static string $resource = CouponsResource::class;

    protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index');
    }

    protected function mutateFormDataBeforeCreate(array $data): array
    {
        // Generate unique code if not provided
        if (empty($data['code'])) {
            $data['code'] = \App\Models\Coupon::generateUniqueCode();
        }
        return $data;
    }
}
