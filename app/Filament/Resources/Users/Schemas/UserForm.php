<?php

namespace App\Filament\Resources\Users\Schemas;

use Filament\Forms\Components\Placeholder;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Components\Grid;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;
use Illuminate\Support\HtmlString;

class UserForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make('Personal Information')
                    ->columnSpanFull()
                    ->schema([
                        Grid::make(2)
                            ->schema([
                                TextInput::make('name')
                                    ->label('Full Name')
                                    ->required()
                                    ->maxLength(255)
                                    ->placeholder('Enter full name')
                                    ->autofocus(),

                                TextInput::make('email')
                                    ->label('Email Address')
                                    ->required()
                                    ->email()
                                    ->maxLength(255)
                                    ->unique(ignoreRecord: true)
                                    ->placeholder('Enter email address')
                                    ->prefixIcon('heroicon-o-envelope'),
                            ]),

                        Grid::make(2)
                            ->schema([
                                TextInput::make('phone')
                                    ->label('Phone Number')
                                    ->tel()
                                    ->maxLength(20)
                                    ->placeholder('Enter phone number')
                                    ->prefixIcon('heroicon-o-phone'),

                                TextInput::make('password')
                                    ->label('Password')
                                    ->password()
                                    ->required(fn($context) => $context === 'create')
                                    ->minLength(8)
                                    ->maxLength(255)
                                    ->placeholder('Enter password')
                                    ->revealable()
                                    ->dehydrated(fn($state) => filled($state))
                                    ->helperText(
                                        fn($context) =>
                                        $context === 'create'
                                            ? 'Password must be at least 8 characters'
                                            : 'Leave blank to keep current password'
                                    ),
                            ]),
                    ]),

                Section::make('Account Status & Rewards')
                    ->columnSpanFull()
                    ->schema([
                        Grid::make(3)
                            ->schema([
                                Toggle::make('status')
                                    ->label('Active Status')
                                    ->default(true)
                                    ->helperText('Enable or disable user account')
                                    ->onColor('success')
                                    ->offColor('danger'),

                              
                                TextInput::make('reward_points')
                                    ->label('Reward Points')
                                    ->numeric()
                                    ->default(0)
                                    ->minValue(0)
                                    ->step(1)
                                    ->helperText('Current reward points balance. Earn: Rs.100 = 10 points')
                                    ->prefixIcon('heroicon-o-star'),


                                Placeholder::make('points_value')
                                    ->label('Points Value')
                                    ->content(function ($record) {
                                        if (!$record) return 'N/A';

                                        $points = $record->reward_points ?? 0;
                                        $redeemValue = $points * 1;

                                        return new HtmlString("
                                            <div>
                                                <strong>Redeem Value:</strong> Rs. " . number_format($redeemValue) . "<br>
                                                <small class='text-gray-500'>
                                                    Earn: Rs.100 = 10 Points | Redeem: 1 Point = Rs.1
                                                </small>
                                            </div>
                                        ");
                                    })
                                    ->helperText('Earn 10 points for every Rs.100 spent. Redeem 1 point = Rs.1'),
                            ]),
                    ]),

                Section::make('Account Statistics')
                    ->schema([
                        Grid::make(4)
                            ->schema([
                                Placeholder::make('order_count')
                                    ->label('Total Orders')
                                    ->content(
                                        fn($record) =>
                                        $record ? $record->orders()->count() : 'N/A'
                                    ),

                                Placeholder::make('total_spent')
                                    ->label('Total Spent')
                                    ->content(
                                        fn($record) =>
                                        $record ? 'Rs. ' . number_format($record->total_spent, 2) : 'N/A'
                                    ),

                                Placeholder::make('address_count')
                                    ->label('Saved Addresses')
                                    ->content(
                                        fn($record) =>
                                        $record ? $record->addresses()->count() : 'N/A'
                                    ),

                                Placeholder::make('points_earned')
                                    ->label('Points Earned')
                                    ->content(
                                        fn($record) =>
                                        $record ? number_format($record->rewardTransactions()->where('type', 'earned')->sum('points')) : 'N/A'
                                    ),
                            ]),
                    ])
                    ->visible(fn($context) => $context === 'edit'),

                Section::make('Recent Orders')
                    ->schema([
                        Placeholder::make('recent_orders')
                            ->label('')
                            ->content(
                                fn($record) =>
                                $record ? new HtmlString(
                                    view('filament.components.user-recent-orders', ['orders' => $record->recentOrders()])->render()
                                ) : 'No orders found'
                            ),
                    ])
                    ->visible(fn($context) => $context === 'edit' && isset($record) && $record->orders()->count() > 0),

                Section::make('Timestamps')
                    ->schema([
                        Grid::make(2)
                            ->schema([
                                Placeholder::make('created_at')
                                    ->label('Created At')
                                    ->content(
                                        fn($record) =>
                                        $record ? $record->created_at->format('F j, Y, g:i A') : 'N/A'
                                    ),

                                Placeholder::make('updated_at')
                                    ->label('Last Updated')
                                    ->content(
                                        fn($record) =>
                                        $record ? $record->updated_at->format('F j, Y, g:i A') : 'N/A'
                                    ),
                            ]),
                    ])
                    ->visible(fn($context) => $context === 'edit'),
            ]);
    }
}
