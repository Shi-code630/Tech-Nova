<?php

namespace App\Filament\Resources\Payments\Schemas;

use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Components\Grid;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;
use Filament\Forms\Components\Placeholder;
use Illuminate\Support\HtmlString;

class PaymentsForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make('Payment Information')
                    ->schema([
                        Grid::make(2)
                            ->schema([
                                Select::make('order_id')
                                    ->label('Order')
                                    ->relationship('order', 'order_number')
                                    ->searchable()
                                    ->preload()
                                    ->required()
                                    ->helperText('Select the order for this payment'),

                                TextInput::make('amount')
                                    ->label('Amount')
                                    ->numeric()
                                    ->required()
                                    ->prefix('Rs.')
                                    ->step(0.01)
                                    ->minValue(0)
                                    ->helperText('Payment amount'),

                                Select::make('payment_method')
                                    ->label('Payment Method')
                                    ->options([
                                        'cash' => 'Cash',
                                        'card' => 'Card',
                                        'bank_transfer' => 'Bank Transfer',
                                        'mobile_banking' => 'Mobile Banking',
                                        'Cash on Delivery' => 'Cash on Delivery',
                                        'esewa' => 'eSewa',
                                        'khalti' => 'Khalti',
                                    ])
                                    ->required()
                                    ->searchable()
                                    ->helperText('Select payment method'),

                                TextInput::make('transaction_id')
                                    ->label('Transaction ID')
                                    ->maxLength(255)
                                    ->nullable()
                                    ->helperText('Transaction ID from payment gateway'),

                                Placeholder::make('payment_screenshot')
                                    ->label('Payment Screenshot')
                                    ->content(function ($record) {
                                        if (!$record?->order?->payment_screenshot) {
                                            return 'No payment screenshot uploaded.';
                                        }

                                        return new \Illuminate\Support\HtmlString(
                                            '<a href="' . asset('storage/' . $record->order->payment_screenshot) . '" target="_blank">
                                                <img
                                                    src="' . asset('storage/' . $record->order->payment_screenshot) . '"
                                                    alt="Payment Screenshot"
                                                    style="max-width: 400px; max-height: 500px; border-radius: 12px; border: 1px solid #ddd;"
                                                >
                                            </a>'
                                        );
                                    })
                                    ->columnSpanFull(),

                                Select::make('status')
                                    ->label('Payment Status')
                                    ->options([
                                        'pending' => 'Pending',
                                        'completed' => 'Completed',
                                        'failed' => 'Failed',
                                        'refunded' => 'Refunded',
                                    ])
                                    ->default('pending')
                                    ->required()
                                    ->helperText('Current payment status'),

                                Textarea::make('gateway_response')
                                    ->label('Gateway Response')
                                    ->rows(3)
                                    ->nullable()
                                    ->helperText('Raw response from payment gateway (JSON)')
                                    ->columnSpanFull(),
                            ]),
                    ]),
            ]);
    }
}
