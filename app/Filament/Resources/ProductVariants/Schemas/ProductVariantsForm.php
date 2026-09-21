<?php

namespace App\Filament\Resources\ProductVariants\Schemas;

use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Components\Grid;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;

class ProductVariantsForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make('Variant Information')
                    ->schema([
                        Grid::make(2)
                            ->schema([
                                Select::make('product_id')
                                    ->label('Product')
                                    ->relationship('product', 'name')
                                    ->searchable()
                                    ->preload()
                                    ->required()
                                    ->helperText('Select the product this variant belongs to'),

                                FileUpload::make('images')
                                    ->label('Variant Images')
                                    ->image()
                                    ->multiple()
                                    ->reorderable()
                                    ->maxFiles(8)
                                    ->disk('public')
                                    ->directory('product-variants')
                                    ->imageResizeTargetWidth('800')
                                    ->imageResizeTargetHeight('800')
                                    ->helperText('Up to 8 photos. First image is the main photo.')
                                    ->columnSpanFull(),
                            ]),
                    ]),

                Section::make('Attributes')
                    ->schema([
                        Grid::make(3)
                            ->schema([
                                TextInput::make('color')
                                    ->label('Color')
                                    ->placeholder('e.g. Red, Blue, Black')
                                    ->maxLength(255),

                                TextInput::make('size')
                                    ->label('Size')
                                    ->placeholder('e.g. S, M, L, XL')
                                    ->maxLength(255),

                                TextInput::make('price')
                                    ->label('Price (Rs.)')
                                    ->numeric()
                                    ->required()
                                    ->prefix('Rs.')
                                    ->step(0.01)
                                    ->minValue(0),
                            ]),
                    ]),

                Section::make('Stock & Status')
                    ->schema([
                        Grid::make(3)
                            ->schema([
                                TextInput::make('stock')
                                    ->label('Stock Quantity')
                                    ->numeric()
                                    ->required()
                                    ->default(0)
                                    ->minValue(0)
                                    ->integer()
                                    ->helperText('Current stock quantity available'),

                                Toggle::make('status')
                                    ->label('Active')
                                    ->default(true)
                                    ->helperText('Enable/disable this variant'),
                            ]),
                    ]),
            ]);
    }
}
