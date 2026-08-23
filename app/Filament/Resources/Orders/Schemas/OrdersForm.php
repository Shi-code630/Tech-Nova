<?php

namespace App\Filament\Resources\Orders\Schemas;

use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Components\Grid;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;

class OrdersForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make('Order Information')
                
                    ->schema([
                        Grid::make(2)
                            ->schema([
                                Select::make('user_id')
                                    ->label('Customer')
                                    ->relationship('user', 'name')
                                    ->searchable()
                                    ->preload()
                                    ->required(),

                                Select::make('address_id')
                                    ->label('Shipping Address')
                                    ->options(function () {
                                        try {
                                            $addresses = \App\Models\Address::all();
                                            $options = [];
                                            foreach ($addresses as $address) {
                                                $options[$address->id] = $address->full_name . ' - ' .
                                                                         $address->address . ', ' .
                                                                         $address->city . ', ' .
                                                                         $address->district;
                                            }
                                            return $options;
                                        } catch (\Exception $e) {
                                            return ['0' => 'No addresses available. Please add an address first.'];
                                        }
                                    })
                                    ->searchable()
                                    ->preload()
                                    ->required()
                                    ->placeholder('Select an address'),

                                Select::make('coupon_id')
                                    ->label('Coupon')
                                    ->options(function () {
                                        try {
                                            return \App\Models\Coupon::pluck('code', 'id')->toArray();
                                        } catch (\Exception $e) {
                                            return [];
                                        }
                                    })
                                    ->searchable()
                                    ->preload()
                                    ->nullable()
                                    ->placeholder('No coupons available'),

                                TextInput::make('order_number')
                                    ->label('Order Number')
                                    ->required()
                                    ->unique(ignoreRecord: true)
                                    ->default('ORD-' . date('Ymd') . '-' . rand(1000, 9999)),
                            ]),
                    ]),

                Section::make('Pricing')
                    ->schema([
                        Grid::make(3)
                            ->schema([
                                //  Subtotal Input
                                TextInput::make('subtotal')
                                    ->label('Subtotal')
                                    ->numeric()
                                    ->required()
                                    ->prefix('Rs.')
                                    ->step(0.01)
                                    ->minValue(0)
                                    ->default(0)
                                    ->live(onBlur: true)
                                    ->afterStateUpdated(function ($state, callable $set, callable $get) {
                                        self::calculateGrandTotal($set, $get);
                                    }),

                                // Discount Input
                                TextInput::make('discount')
                                    ->label('Discount')
                                    ->numeric()
                                    ->default(0)
                                    ->prefix('Rs.')
                                    ->step(0.01)
                                    ->minValue(0)
                                    ->live(onBlur: true)
                                    ->afterStateUpdated(function ($state, callable $set, callable $get) {
                                        self::calculateGrandTotal($set, $get);
                                    }),

                                // Delivery Charge Input
                                TextInput::make('delivery_charge')
                                    ->label('Delivery Charge')
                                    ->numeric()
                                    ->default(0)
                                    ->prefix('Rs.')
                                    ->step(0.01)
                                    ->minValue(0)
                                    ->live(onBlur: true)
                                    ->afterStateUpdated(function ($state, callable $set, callable $get) {
                                        self::calculateGrandTotal($set, $get);
                                    }),

                                //  Tax Percentage Input
                                TextInput::make('tax_percentage')
                                    ->label('Tax (%)')
                                    ->numeric()
                                    ->default(13)
                                    ->prefix('%')
                                    ->step(0.1)
                                    ->minValue(0)
                                    ->maxValue(100)
                                    ->live(onBlur: true)
                                    ->afterStateUpdated(function ($state, callable $set, callable $get) {
                                        self::calculateGrandTotal($set, $get);
                                    })
                                    ->helperText('Enter tax percentage (e.g., 13 for 13% VAT)'),

                                // Tax Amount (Auto-calculated, read-only)
                                TextInput::make('tax')
                                    ->label('Tax Amount')
                                    ->numeric()
                                    ->default(0)
                                    ->prefix('Rs.')
                                    ->step(0.01)
                                    ->minValue(0)
                                    ->disabled()
                                    ->dehydrated()
                                    ->helperText('Auto-calculated from subtotal'),

                                //  Grand Total (Auto-calculated, read-only)
                                TextInput::make('grand_total')
                                    ->label('Grand Total')
                                    ->numeric()
                                    ->required()
                                    ->prefix('Rs.')
                                    ->step(0.01)
                                    ->minValue(0)
                                    ->disabled()
                                    ->dehydrated()
                                    ->default(0)
                                    ->helperText('Auto-calculated from all fields'),
                            ]),
                    ]),

                Section::make('Payment & Status')
                    ->schema([
                        Grid::make(2)
                            ->schema([
                                TextInput::make('payment_method')
                                    ->label('Payment Method')
                                    ->placeholder('e.g. Cash, Card, Bank Transfer')
                                    ->maxLength(255),

                                Select::make('payment_status')
                                    ->label('Payment Status')
                                    ->options([
                                        'pending' => 'Pending',
                                        'paid' => 'Paid',
                                        'failed' => 'Failed',
                                        'refunded' => 'Refunded',
                                    ])
                                    ->default('pending')
                                    ->required(),

                                Select::make('order_status')
                                    ->label('Order Status')
                                    ->options([
                                        'pending' => 'Pending',
                                        'processing' => 'Processing',
                                        'shipped' => 'Shipped',
                                        'delivered' => 'Delivered',
                                        'cancelled' => 'Cancelled',
                                    ])
                                    ->default('pending')
                                    ->required(),

                                TextInput::make('transaction_id')
                                    ->label('Transaction ID')
                                    ->maxLength(255)
                                    ->nullable(),
                            ]),
                    ]),

                Section::make('Additional Information')
                    ->schema([
                        Textarea::make('notes')
                            ->label('Order Notes')
                            ->rows(3)
                            ->nullable(),
                    ]),
            ]);
    }

    /**
     * Calculate grand total based on subtotal, discount, delivery charge, and tax percentage
     */
    private static function calculateGrandTotal(callable $set, callable $get)
    {
        // Get values and convert to float properly
        $subtotal = floatval($get('subtotal') ?: 0);
        $discount = floatval($get('discount') ?: 0);
        $deliveryCharge = floatval($get('delivery_charge') ?: 0);
        $taxPercentage = floatval($get('tax_percentage') ?: 0);


        $taxAmount = ($subtotal * $taxPercentage) / 100;


        $grandTotal = $subtotal - $discount + $deliveryCharge + $taxAmount;


        if ($grandTotal < 0) {
            $grandTotal = 0;
        }

        // Update tax amount and grand total fields
        $set('tax', number_format($taxAmount, 2, '.', ''));
        $set('grand_total', number_format($grandTotal, 2, '.', ''));
    }
}
