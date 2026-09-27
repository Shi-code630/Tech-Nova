<?php

namespace App\Filament\Resources\SpinRewards\Schemas;

use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Schema;

class SpinRewardForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([

                TextInput::make('name')
                    ->label('Reward Name')
                    ->placeholder('Example: 10% Discount')
                    ->required()
                    ->maxLength(255),

                Select::make('type')
                    ->label('Reward Type')
                    ->options([
                        'discount' => 'Discount',
                        'coins' => 'Coins',
                        'gift' => 'Gift',
                    ])
                    ->required()
                    ->live(),

                TextInput::make('discount_percent')
                    ->label('Discount Percentage')
                    ->numeric()
                    ->minValue(1)
                    ->maxValue(100)
                    ->suffix('%')
                    ->visible(
                        fn ($get) => $get('type') === 'discount'
                    )
                    ->required(
                        fn ($get) => $get('type') === 'discount'
                    ),

                TextInput::make('coins')
                    ->label('Coins')
                    ->numeric()
                    ->minValue(1)
                    ->suffix('Coins')
                    ->visible(
                        fn ($get) => $get('type') === 'coins'
                    )
                    ->required(
                        fn ($get) => $get('type') === 'coins'
                    ),

                TextInput::make('probability')
                    ->label('Winning Probability')
                    ->numeric()
                    ->minValue(0)
                    ->maxValue(100)
                    ->step(0.01)
                    ->suffix('%')
                    ->helperText(
                        'Total probability of all active rewards should normally be 100%.'
                    )
                    ->required(),

                TextInput::make('stock')
                    ->label('Stock')
                    ->numeric()
                    ->minValue(0)
                    ->placeholder('Leave empty for unlimited')
                    ->helperText(
                        'Empty = unlimited stock. 0 = reward unavailable.'
                    ),

                Textarea::make('description')
                    ->label('Description')
                    ->placeholder('Describe this reward...')
                    ->rows(3)
                    ->maxLength(1000)
                    ->columnSpanFull(),

                Toggle::make('status')
                    ->label('Active')
                    ->default(true)
                    ->helperText(
                        'Only active rewards can be selected by the Spin & Win system.'
                    ),
            ]);
    }
}
