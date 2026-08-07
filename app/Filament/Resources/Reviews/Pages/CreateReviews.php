<?php

namespace App\Filament\Resources\Reviews\Pages;

use App\Filament\Resources\Reviews\ReviewsResource;
use Filament\Resources\Pages\CreateRecord;

class CreateReviews extends CreateRecord
{
    protected static string $resource = ReviewsResource::class;

    protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index');
    }
}
