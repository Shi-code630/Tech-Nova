<?php

namespace App\Filament\Resources\SpinRewards\Pages;

use App\Filament\Resources\SpinRewards\SpinRewardResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;

class ListSpinRewards extends ListRecords
{
    protected static string $resource = SpinRewardResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make()
                ->label('Create New'),
        ];
    }
}
