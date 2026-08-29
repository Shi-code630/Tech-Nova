<?php

namespace App\Filament\Resources\Products\Schemas;

use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Repeater;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Components\Grid;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;
use Illuminate\Support\Str;

class ProductForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema

            ->components([
                Section::make('Product Information')
                    ->columnSpanFull()
                    ->schema([
                        Grid::make(2)
                            ->schema([

                                Select::make('category_id')
                                    ->label('Category')
                                    ->relationship('category', 'name')
                                    ->searchable()
                                    ->preload()
                                    ->required(),

                                Select::make('brand_id')
                                    ->label('Brand')
                                    ->relationship('brand', 'name')
                                    ->searchable()
                                    ->preload()
                                    ->required(),

                                TextInput::make('name')
                                    ->label('Product Name')
                                    ->required()
                                    ->maxLength(255)
                                    ->live(onBlur: true)
                                    ->afterStateUpdated(
                                        function ($state, callable $set) {
                                            $set(
                                                'slug',
                                                Str::slug($state)
                                            );
                                        }
                                    ),

                                TextInput::make('slug')
                                    ->label('Slug')
                                    ->required()
                                    ->maxLength(255)
                                    ->unique(ignoreRecord: true),

                                Textarea::make('description')
                                    ->label('Description')
                                    ->required()
                                    ->rows(5)
                                    ->columnSpanFull(),
                            ]),
                    ]),


                Section::make('Pricing & Stock')
                    ->schema([
                        Grid::make(3)
                            ->schema([

                                TextInput::make('price')
                                    ->label('Price (Rs.)')
                                    ->numeric()
                                    ->required()
                                    ->prefix('Rs.')
                                    ->step(0.01)
                                    ->minValue(0),

                                TextInput::make('discount_price')
                                    ->label('Discount Price (Rs.)')
                                    ->numeric()
                                    ->prefix('Rs.')
                                    ->step(0.01)
                                    ->minValue(0)
                                    ->helperText(
                                        'Leave empty if there is no discount.'
                                    ),

                                TextInput::make('stock')
                                    ->label('Stock Quantity')
                                    ->numeric()
                                    ->required()
                                    ->default(0)
                                    ->minValue(0)
                                    ->integer(),
                            ]),
                    ]),


                Section::make('Product Images')
                    ->schema([

                        FileUpload::make('thumbnails')
                            ->label('Product Images')
                            ->image()
                            ->multiple()
                            ->disk('public')
                            ->directory('products')
                            ->imageResizeTargetWidth('800')
                            ->imageResizeTargetHeight('800')
                            ->reorderable()
                            ->appendFiles()
                            ->helperText(
                                'Upload multiple product images. Recommended: 800x800.'
                            ),
                    ]),



                Section::make('Product Variants')
                    ->description(
                        'Add color, size, price and stock variations for this product.'
                    )
                    ->columnSpanFull()
                    ->schema([

                        Repeater::make('variants')
                            ->relationship('variants')
                            ->label('Variants')
                            ->schema([

                                Grid::make(4)
                                    ->schema([

                                        TextInput::make('color')
                                            ->label('Color')
                                            ->placeholder(
                                                'e.g. Red, Blue, Black'
                                            )
                                            ->maxLength(255),

                                        TextInput::make('size')
                                            ->label('Size')
                                            ->placeholder(
                                                'e.g. S, M, L, XL'
                                            )
                                            ->maxLength(255),

                                        TextInput::make('price')
                                            ->label('Price (Rs.)')
                                            ->numeric()
                                            ->default(0)
                                            ->prefix('Rs.')
                                            ->step(0.01)
                                            ->minValue(0),

                                        TextInput::make('stock')
                                            ->label('Stock')
                                            ->numeric()

                                            ->default(0)
                                            ->integer()
                                            ->minValue(0),
                                    ]),

                                Grid::make(2)
                                    ->schema([

                                        FileUpload::make('image')
                                            ->label('Variant Image')
                                            ->image()
                                            ->disk('public')
                                            ->directory('product-variants')
                                            ->imageResizeTargetWidth('500')
                                            ->imageResizeTargetHeight('500')
                                            ->helperText(
                                                'Optional variant image.'
                                            ),

                                        Toggle::make('status')
                                            ->label('Active')
                                            ->default(true),
                                    ]),
                            ])
                            ->columns(1)
                            ->defaultItems(0)
                            ->addActionLabel('Add Product Variant')
                            ->collapsible()
                            ->itemLabel(
                                fn(array $state): ?string =>
                                trim(
                                    ($state['color'] ?? '') .
                                        ' ' .
                                        ($state['size'] ?? '')
                                ) ?: 'New Variant'
                            )
                            ->reorderable()
                            ->cloneable(),
                    ]),


                Section::make('Meta Information')
                    ->columnSpanFull()
                    ->collapsed()
                    ->schema([
                        Grid::make(2)
                            ->schema([

                                TextInput::make('meta_title')
                                    ->label('Meta Title')
                                    ->maxLength(255),

                                TextInput::make('meta_keywords')
                                    ->label('Meta Keywords')
                                    ->maxLength(255),

                                Textarea::make('meta_description')
                                    ->label('Meta Description')
                                    ->rows(3)
                                    ->columnSpanFull(),
                            ]),
                    ]),

                // ==========================================
                // STATUS & FEATURED
                // ==========================================

                Section::make('Status & Featured')
                    ->schema([
                        Grid::make(2)
                            ->schema([

                                Select::make('status')
                                    ->label('Status')
                                    ->options([
                                        'active' => 'Active',
                                        'inactive' => 'Inactive',
                                        'out_of_stock' => 'Out of Stock',
                                    ])
                                    ->default('active')
                                    ->required(),

                                Toggle::make('featured')
                                    ->label('Featured Product')
                                    ->default(false)
                                    ->helperText(
                                        'Show this product in the featured section.'
                                    ),
                            ]),
                    ]),
            ]);
    }
}
