<?php

namespace App\Filament\Resources\Brands\Pages;

use App\Filament\Resources\Brands\BrandsResource;
use Filament\Actions\DeleteAction;
use Filament\Resources\Pages\EditRecord;

class EditBrands extends EditRecord
{
    protected static string $resource = BrandsResource::class;

    protected function getHeaderActions(): array
    {
        return [
            DeleteAction::make(),
        ];
    }

    protected function getRedirectUrl(): string
    {
        // Redirect to the index page after successful update
        return $this->getResource()::getUrl('index');
    }

    // Optional: customize the save button label
    // protected function getSaveFormAction(): \Filament\Actions\Action
    // {
    //     return parent::getSaveFormAction()
    //         ->label('Update Brand');
    // }
}
