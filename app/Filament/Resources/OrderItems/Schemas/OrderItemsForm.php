<?php

namespace App\Filament\Resources\OrderItems\Schemas;

use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Components\Grid;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;

class OrderItemsForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make('Order Item Details')
                ->columnSpanFull()
                    ->schema([
                        Grid::make(2)
                            ->schema([
                                Select::make('order_id')
                                    ->label('Order')
                                    ->relationship('order', 'order_number')
                                    ->searchable()
                                    ->preload()
                                    ->required(),

                                Select::make('product_id')
                                    ->label('Product')
                                    ->relationship('product', 'name')
                                    ->searchable()
                                    ->preload()
                                    ->required(),

                                //  Using options instead of relationship
                                Select::make('variant_id')
                                    ->label('Variant')
                                    ->options(function () {
                                        try {
                                            return \App\Models\ProductVariant::all()
                                                ->mapWithKeys(function ($variant) {
                                                    $label = '';
                                                    if ($variant->color) {
                                                        $label .= $variant->color;
                                                    }
                                                    if ($variant->size) {
                                                        $label .= $label ? ' - ' . $variant->size : $variant->size;
                                                    }
                                                    return [$variant->id => $label ?: 'Default'];
                                                })
                                                ->toArray();
                                        } catch (\Exception $e) {
                                            return [];
                                        }
                                    })
                                    ->searchable()
                                    ->preload()
                                    ->nullable()
                                    ->placeholder('No variant')
                                    ->helperText('Select variant (optional)'),

                                TextInput::make('quantity')
                                    ->label('Quantity')
                                    ->numeric()
                                    ->required()
                                    ->minValue(1)
                                    ->default(1)
                                    ->live(onBlur: true)
                                    ->afterStateUpdated(function ($state, callable $set, callable $get) {
                                        self::calculateTotal($set, $get);
                                    }),

                                TextInput::make('price')
                                    ->label('Price')
                                    ->numeric()
                                    ->required()
                                    ->prefix('Rs.')
                                    ->step(0.01)
                                    ->minValue(0)
                                    ->live(onBlur: true)
                                    ->afterStateUpdated(function ($state, callable $set, callable $get) {
                                        self::calculateTotal($set, $get);
                                    }),

                                TextInput::make('total')
                                    ->label('Total')
                                    ->numeric()
                                    ->required()
                                    ->prefix('Rs.')
                                    ->step(0.01)
                                    ->minValue(0)
                                    ->disabled()
                                    ->dehydrated()
                                    ->helperText('Auto-calculated: Quantity × Price'),
                            ]),
                    ]),
            ]);
    }

    private static function calculateTotal(callable $set, callable $get)
    {
        $quantity = floatval($get('quantity') ?: 0);
        $price = floatval($get('price') ?: 0);
        $total = $quantity * $price;
        $set('total', number_format($total, 2, '.', ''));
    }
}
