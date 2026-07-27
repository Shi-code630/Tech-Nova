<?php

namespace App\Filament\Resources\Products\Schemas;

use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\Toggle;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\RichEditor;
use Filament\Schemas\Schema;
use Illuminate\Validation\Rule;

class ProductForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Select::make('category_id')
                    ->label('Category')
                    ->relationship('categories', 'name')
                    ->required()
                    ->searchable()
                    ->preload()
                    ->helperText('Select the product category.'),

                Select::make('brand_id')
                    ->label('Brand')
                    ->relationship('brand', 'name')
                    ->required()
                    ->searchable()
                    ->preload()
                    ->helperText('Select the product brand.'),

                TextInput::make('name')
                    ->label('Product Name')
                    ->required()
                    ->maxLength(255)
                    ->live(onBlur: true)
                    ->afterStateUpdated(function ($state, callable $set) {
                        $set('slug', \Illuminate\Support\Str::slug($state));
                    }),

                TextInput::make('slug')
                    ->label('Slug')
                    ->required()
                    ->maxLength(255)
                    ->unique(ignoreRecord: true)
                    ->helperText('Unique URL-friendly identifier.'),

                RichEditor::make('description')
                    ->label('Description')
                    ->required()
                    ->fileAttachmentsDisk('public')
                    ->fileAttachmentsDirectory('products/descriptions')
                    ->toolbarButtons([
                        'bold', 'italic', 'underline', 'strike',
                        'link', 'bulletList', 'orderedList',
                        'blockquote', 'codeBlock', 'h2', 'h3',
                    ])
                    ->columnSpanFull(),

                TextInput::make('price')
                    ->label('Price')
                    ->required()
                    ->numeric()
                    ->prefix('Rs.')
                    ->step(0.01)
                    ->minValue(0),

                TextInput::make('discount_price')
                    ->label('Discount Price')
                    ->numeric()
                    ->prefix('Rs.')
                    ->step(0.01)
                    ->minValue(0)
                    ->nullable()
                    ->helperText('Leave empty if no discount.'),

                TextInput::make('stock')
                    ->label('Stock Quantity')
                    ->required()
                    ->integer()
                    ->minValue(0)
                    ->default(0),

                Select::make('status')
                    ->label('Status')
                    ->options([
                        'active' => 'Active',
                        'inactive' => 'Inactive',
                        'out_of_stock' => 'Out of Stock',
                    ])
                    ->required()
                    ->default('active'),

                FileUpload::make('thumbnails')
                    ->label('Thumbnails')
                    ->multiple()
                    ->image()
                    ->imagePreviewHeight('100')
                    ->directory('products/thumbnails')
                    ->disk('public')
                    ->maxSize(2048)
                    ->helperText('Upload up to 5 images.'),
                    // You can enforce count with ->minFiles(1)->maxFiles(5)

                Toggle::make('featured')
                    ->label('Featured Product')
                    ->default(false)
                    ->inline(false),

                TextInput::make('meta_title')
                    ->label('Meta Title')
                    ->maxLength(255)
                    ->nullable(),

                Textarea::make('meta_description')
                    ->label('Meta Description')
                    ->rows(3)
                    ->nullable(),

                TextInput::make('meta_keywords')
                    ->label('Meta Keywords')
                    ->maxLength(255)
                    ->nullable(),
            ]);
    }
}
