<?php

namespace App\Filament\Resources\UserAddresses\Pages;

use App\Filament\Resources\UserAddresses\UserAddressResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListUserAddresses extends ListRecords
{
    protected static string $resource = UserAddressResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make()
                ->label('New Address')
                ->icon('heroicon-o-plus'),
        ];
    }
}
