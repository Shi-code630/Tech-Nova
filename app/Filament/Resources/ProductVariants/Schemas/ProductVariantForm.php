<?php

namespace App\Filament\Resources\ProductVariants\Schemas;

use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Schema;

class ProductVariantsForm
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
                    ->helperText('Select the product this variant belongs to.'),

                TextInput::make('color')
                    ->label('Color')
                    ->maxLength(255)
                    ->nullable(),

                TextInput::make('size')
                    ->label('Size')
                    ->maxLength(255)
                    ->nullable(),

                TextInput::make('price')
                    ->label('Price')
                    ->required()
                    ->numeric()
                    ->prefix('Rs.')
                    ->step(0.01)
                    ->minValue(0),

                TextInput::make('stock')
                    ->label('Stock')
                    ->required()
                    ->integer()
                    ->minValue(0)
                    ->default(0),

                FileUpload::make('image')
                    ->label('Variant Image')
                    ->image()
                    ->imagePreviewHeight('150')
                    ->directory('variants/images')
                    ->disk('public')
                    ->maxSize(2048)
                    ->nullable(),

                Toggle::make('status')
                    ->label('Active')
                    ->default(true)
                    ->inline(false),
            ]);
    }
}
