<?php

namespace App\Filament\Resources\RewardTransactions\Schemas;

use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Components\Grid;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;

class RewardTransactionForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make('Reward Transaction Details')
                    ->schema([
                        Grid::make(2)
                            ->schema([
                                Select::make('user_id')
                                    ->label('Customer')
                                    ->relationship('user', 'name')
                                    ->searchable()
                                    ->preload()
                                    ->required(),

                                Select::make('order_id')
                                    ->label('Order')
                                    ->relationship('order', 'order_number')
                                    ->searchable()
                                    ->preload()
                                    ->nullable()
                                    ->helperText('Select order if this is from an order'),

                                Select::make('type')
                                    ->label('Transaction Type')
                                    ->options([
                                        'earned' => 'Earned Points',
                                        'redeemed' => 'Redeemed Points',
                                    ])
                                    ->default('earned')
                                    ->required()
                                    ->helperText('Select whether points were earned or redeemed'),

                                TextInput::make('points')
                                    ->label('Points Amount')
                                    ->numeric()
                                    ->required()
                                    ->minValue(1)
                                    ->integer()
                                    ->helperText('Number of points for this transaction'),

                                Textarea::make('remarks')
                                    ->label('Remarks / Description')
                                    ->rows(3)
                                    ->nullable()
                                    ->placeholder('Add any remarks about this transaction'),
                            ]),
                    ]),
            ]);
    }
}
