<?php

namespace App\Filament\Resources\RewardTransactions\Pages;

use App\Filament\Resources\RewardTransactions\RewardTransactionResource;
use Filament\Resources\Pages\CreateRecord;

class CreateRewardTransaction extends CreateRecord
{
    protected static string $resource = RewardTransactionResource::class;

    protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index');
    }
}
