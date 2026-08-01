<?php

namespace App\Filament\Resources\ProductImages\Pages;

use App\Filament\Resources\ProductImages\ProductImagesResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;

class ListProductImages extends ListRecords
{
    protected static string $resource = ProductImagesResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make()
<<<<<<< HEAD
                ->label('Add Image')
=======
                ->label('New Image')
>>>>>>> 81e6788f98b84bc680e004fdfca6cf661a1af07b
                ->icon('heroicon-o-plus'),
        ];
    }
}
