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
        return $schema->schema([
            Section::make('Order Information')
             ->columnSpanFull()
                ->schema([
                    Grid::make(2)
                        ->schema([
                            TextInput::make('order_number')
                                ->label('Order Number')
                                ->disabled()
                                ->default('ORD-' . date('Ymd') . '-' . rand(1000, 9999)),

                            Select::make('user_id')
                                ->label('Customer')
                                ->relationship('user', 'name')
                                ->searchable()
                                ->preload()
                                ->required(),
                        ]),
                ]),

            Section::make('Order Details')
                 ->columnSpanFull()
                ->schema([
                    Grid::make(2)
                        ->schema([
                            Select::make('order_status')
                                ->label('Order Status')
                                ->options([
                                    'pending' => 'Pending',
                                    'processing' => 'Processing',
                                    'shipped' => 'Shipped',
                                    'out_for_delivery' => 'Out for Delivery',
                                    'delivered' => 'Delivered',
                                    'cancelled' => 'Cancelled',
                                    'returned' => 'Returned',
                                ])
                                ->required()
                                ->native(false)
                                ->default('pending'),

                            Select::make('payment_status')
                                ->label('Payment Status')
                                ->options([
                                    'pending' => 'Pending',
                                    'paid' => 'Paid',
                                    'failed' => 'Failed',
                                    'refunded' => 'Refunded',
                                ])
                                ->default('pending')
                                ->native(false),

                            TextInput::make('current_location')
                                ->label('Current Location')
                                ->placeholder('e.g. Kathmandu Sorting Hub')
                                ->maxLength(255),

                            TextInput::make('payment_method')
                                ->label('Payment Method')
                                ->placeholder('e.g. Cash, Card, Bank Transfer')
                                ->maxLength(255),

                            TextInput::make('tracking_number')
                                ->label('Tracking Number')
                                ->placeholder('e.g. TRK-123456')
                                ->maxLength(255),

                            TextInput::make('courier_name')
                                ->label('Courier Name')
                                ->placeholder('e.g. DHL, FedEx, Nepal Post')
                                ->maxLength(255),

                            TextInput::make('transaction_id')
                                ->label('Transaction ID')
                                ->maxLength(255)
                                ->nullable(),
                        ]),
                ]),

            Section::make('Pricing')
                ->schema([
                    Grid::make(3)
                        ->schema([
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

            Section::make('Additional Information')
                ->schema([
                    Textarea::make('notes')
                        ->label('Order Notes')
                        ->rows(3)
                        ->nullable()
                        ->columnSpanFull(),
                ]),
        ]);
    }

    /**
     * Calculate grand total based on subtotal, discount, delivery charge, and tax percentage
     */
    private static function calculateGrandTotal(callable $set, callable $get): void
    {
        $subtotal = floatval($get('subtotal') ?: 0);
        $discount = floatval($get('discount') ?: 0);
        $deliveryCharge = floatval($get('delivery_charge') ?: 0);
        $taxPercentage = floatval($get('tax_percentage') ?: 0);

        $taxAmount = ($subtotal * $taxPercentage) / 100;
        $grandTotal = $subtotal - $discount + $deliveryCharge + $taxAmount;

        if ($grandTotal < 0) {
            $grandTotal = 0;
        }

        $set('tax', number_format($taxAmount, 2, '.', ''));
        $set('grand_total', number_format($grandTotal, 2, '.', ''));
    }
}
