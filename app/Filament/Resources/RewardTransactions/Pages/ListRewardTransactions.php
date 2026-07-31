<?php

namespace App\Filament\Resources\RewardTransactions\Pages;

use App\Filament\Resources\RewardTransactions\RewardTransactionResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;

class ListRewardTransactions extends ListRecords
{
    protected static string $resource = RewardTransactionResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make()
                ->label('New Transaction')
                ->icon('heroicon-o-plus'),
        ];
    }
}
