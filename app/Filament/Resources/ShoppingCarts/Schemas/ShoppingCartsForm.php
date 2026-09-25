<?php

namespace App\Filament\Resources\ShoppingCarts\Schemas;

use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Components\Grid;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;

class ShoppingCartsForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make('Cart Item Details')
                    ->columnSpanFull()
                    ->schema([
                        Grid::make(2)
                            ->schema([
                                Select::make('user_id')
                                    ->label('Customer')
                                    ->relationship('user', 'name')
                                    ->searchable()
                                    ->preload()
                                    ->required(),

                                Select::make('product_id')
                                    ->label('Product')
                                    ->relationship('product', 'name')
                                    ->searchable()
                                    ->preload()
                                    ->required(),

                                Select::make('variant_id')
                                    ->label('Variant')
                                    ->relationship(
                                        name: 'variant',
                                        titleAttribute: 'color',
                                        modifyQueryUsing: fn($query) => $query
                                            ->whereNotNull('color')
                                            ->where('color', '!=', '')
                                    )
                                    ->getOptionLabelFromRecordUsing(
                                        fn($record) => trim(($record->color ?? '') . ' / ' . ($record->size ?? ''))
                                            ?: 'Variant #' . $record->id
                                    )
                                    ->searchable()
                                    ->preload(),
                                TextInput::make('quantity')
                                    ->label('Quantity')
                                    ->numeric()
                                    ->required()
                                    ->minValue(1)
                                    ->default(1)
                                    ->live(onBlur: true)
                                    ->afterStateUpdated(function ($state, callable $set, callable $get) {
                                        self::updateTotal($set, $get);
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
                                        self::updateTotal($set, $get);
                                    }),
                            ]),
                    ]),
            ]);
    }

    private static function updateTotal(callable $set, callable $get)
    {

        $quantity = floatval($get('quantity') ?: 0);
        $price = floatval($get('price') ?: 0);
        $total = $quantity * $price;


        // $set('total', number_format($total, 2, '.', ''));
    }
}
