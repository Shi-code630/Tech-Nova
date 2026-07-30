<?php

namespace App\Filament\Resources\ProductImages\Schemas;

use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Select;
use Filament\Schemas\Components\Grid;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;

class ProductImageForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make('Product Image')
                    ->schema([
                        Grid::make(1)
                            ->schema([
                                Select::make('product_id')
                                    ->label('Product')
                                    ->relationship('product', 'name')
                                    ->searchable()
                                    ->preload()
                                    ->required()
                                    ->helperText('Select the product for this image'),

                                FileUpload::make('image')
                                    ->label('Image')
                                    ->image()
                                    ->required()
                                    ->directory('product-images')
                                    ->imageResizeTargetWidth('800')
                                    ->imageResizeTargetHeight('800')
                                    ->helperText('Upload product image (recommended: 800x800)'),
                            ]),
                    ]),
            ]);
    }
}
