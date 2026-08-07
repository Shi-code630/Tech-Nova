<?php

namespace App\Filament\Resources\ContactMessages\Pages;

use App\Filament\Resources\ContactMessages\ContactMessagesResource;
use Filament\Resources\Pages\CreateRecord;

class CreateContactMessages extends CreateRecord
{
    protected static string $resource = ContactMessagesResource::class;

    protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index');
    }
}
