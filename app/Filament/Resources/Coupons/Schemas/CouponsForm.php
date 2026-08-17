<?php

namespace App\Filament\Resources\Coupons\Schemas;

use Filament\Forms\Components\DateTimePicker;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Components\Grid;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;

class CouponsForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make('Coupon Information')
                ->columnSpanFull()
                    ->schema([
                        Grid::make(2)
                            ->schema([
                                TextInput::make('code')
                                    ->label('Coupon Code')
                                    ->required()
                                    ->maxLength(255)
                                    ->unique(ignoreRecord: true)
                                    ->placeholder('e.g. SUMMER2024')
                                    ->helperText('Coupon code will be automatically uppercased'),

                                Select::make('type')
                                    ->label('Discount Type')
                                    ->options([
                                        'percentage' => 'Percentage (%)',
                                        'fixed' => 'Fixed Amount',
                                    ])
                                    ->required()
                                    ->default('percentage')
                                    ->helperText('Select the type of discount'),

                                TextInput::make('amount')
                                    ->label('Discount Amount')
                                    ->numeric()
                                    ->required()
                                    ->prefix(fn ($get) => $get('type') === 'percentage' ? '%' : 'Rs.')
                                    ->step(0.01)
                                    ->minValue(0)
                                    ->helperText('Enter discount amount'),

                                TextInput::make('minimum_amount')
                                    ->label('Minimum Order Amount')
                                    ->numeric()
                                    ->nullable()
                                    ->prefix('Rs.')
                                    ->step(0.01)
                                    ->minValue(0)
                                    ->helperText('Minimum order amount required to use this coupon'),

                                TextInput::make('maximum_discount')
                                    ->label('Maximum Discount')
                                    ->numeric()
                                    ->nullable()
                                    ->prefix('Rs.')
                                    ->step(0.01)
                                    ->minValue(0)
                                    ->helperText('Maximum discount limit (only for percentage coupons)'),
                            ]),
                    ]),

                Section::make('Usage Limits')
                    ->schema([
                        Grid::make(2)
                            ->schema([
                                TextInput::make('usage_limit')
                                    ->label('Usage Limit')
                                    ->numeric()
                                    ->nullable()
                                    ->minValue(1)
                                    ->integer()
                                    ->helperText('Maximum number of times this coupon can be used'),

                                TextInput::make('used')
                                    ->label('Used Count')
                                    ->numeric()
                                    ->default(0)
                                    ->minValue(0)
                                    ->integer()
                                    ->helperText('Number of times this coupon has been used'),
                            ]),
                    ]),

                Section::make('Date Range')
                    ->schema([
                        Grid::make(2)
                            ->schema([
                                DateTimePicker::make('start_date')
                                    ->label('Start Date')
                                    ->nullable()
                                    ->helperText('When the coupon becomes active'),

                                DateTimePicker::make('expire_date')
                                    ->label('Expire Date')
                                    ->nullable()
                                    ->helperText('When the coupon expires'),
                            ]),
                    ]),

                Section::make('Status')
                    ->schema([
                        Toggle::make('status')
                            ->label('Active')
                            ->default(true)
                            ->helperText('Enable or disable this coupon'),
                    ]),
            ]);
    }
}
