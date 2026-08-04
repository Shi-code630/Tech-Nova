<?php

namespace App\Filament\Resources\ContactMessages\Pages;

use App\Filament\Resources\ContactMessages\ContactMessagesResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;

class ListContactMessages extends ListRecords
{
    protected static string $resource = ContactMessagesResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make()
                ->label('New Message')
                ->icon('heroicon-o-plus'),
        ];
    }
}
