<?php

namespace App\Filament\Resources\ProductImages\Schemas;

use Filament\Forms\Components\Select;
use Filament\Forms\Components\FileUpload;
use Filament\Schemas\Schema;

class ProductImageForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Select::make('product_id')
                    ->label('Product')
                    ->relationship('product', 'name')
                    ->required()
                    ->searchable()
                    ->preload()
                    ->helperText('Select the product this image belongs to.'),

                FileUpload::make('image')
                    ->label('Image')
                    ->image()
                    ->imagePreviewHeight('200')
                    ->directory('products/images')
                    ->disk('public')
                    ->maxSize(2048)
                    ->required()
                    ->helperText('Upload a product image (max 2MB).'),
            ]);
    }
}
