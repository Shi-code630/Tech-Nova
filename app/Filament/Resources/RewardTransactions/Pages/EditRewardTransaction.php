<?php

namespace App\Filament\Resources\RewardTransactions\Pages;

use App\Filament\Resources\RewardTransactions\RewardTransactionResource;
use Filament\Actions\DeleteAction;
use Filament\Actions\ForceDeleteAction;
use Filament\Actions\RestoreAction;
use Filament\Resources\Pages\EditRecord;

class EditRewardTransaction extends EditRecord
{
    protected static string $resource = RewardTransactionResource::class;

    protected function getHeaderActions(): array
    {
        return [
            DeleteAction::make(),
            ForceDeleteAction::make(),
            RestoreAction::make(),
        ];
    }

    protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index');
    }
}
