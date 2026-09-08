<?php

namespace App\Filament\Resources\Users\Schemas;

use Filament\Forms\Components\Placeholder;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Components\Grid;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;
use Illuminate\Support\HtmlString;
use App\Helpers\RewardHelper;

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

               
                Section::make('Account Status & Coins')
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
                                    ->label('Coins Balance')
                                    ->numeric()
                                    ->default(0)
                                    ->minValue(0)
                                    ->step(1)
                                    ->helperText('Current coin balance. Earn: Rs.100 = 1 coin | Redeem: 20 coins = Rs.1')
                                    ->prefixIcon('heroicon-o-star'),


                                Placeholder::make('points_value')
                                    ->label('Coins Value')
                                    ->content(function ($record) {
                                        if (!$record) return 'N/A';

                                        $points = $record->reward_points ?? 0;
                                        $redeemRate = RewardHelper::getRedeemRate();
                                        $redeemValue = $points / $redeemRate;

                                        return new HtmlString("
                                            <div class='space-y-1'>
                                                <div>
                                                    <span class='font-semibold'>Redeem Value:</span>
                                                    <span class='text-green-600 font-bold'>Rs. " . number_format($redeemValue, 2) . "</span>
                                                </div>
                                                <div class='text-xs text-gray-500'>
                                                    Earn: Rs." . RewardHelper::getEarnRate() . " = 1 Coin | Redeem: " . RewardHelper::getRedeemRate() . " Coins = Rs.1
                                                </div>
                                                <div class='text-xs text-gray-400'>
                                                    Total Coins: <span class='font-semibold'>" . number_format($points) . "</span>
                                                </div>
                                            </div>
                                        ");
                                    })
                                    ->helperText('Earn 1 coin for every Rs.' . RewardHelper::getEarnRate() . ' spent. Redeem ' . RewardHelper::getRedeemRate() . ' coins = Rs.1'),
                            ]),
                    ]),

                Section::make('Coin Transaction History')
                    ->columnSpanFull()
                    ->schema([
                        Placeholder::make('coin_history')
                            ->label('')
                            ->content(function ($record) {
                                if (!$record) return 'N/A';

                                $transactions = $record->rewardTransactions()
                                    ->orderBy('created_at', 'desc')
                                    ->limit(10)
                                    ->get();

                                if ($transactions->isEmpty()) {
                                    return new HtmlString("<p class='text-gray-500'>No coin transactions yet.</p>");
                                }

                                $html = '<div class="overflow-x-auto">';
                                $html .= '<table class="w-full text-sm">';
                                $html .= '<thead><tr class="border-b border-gray-200">';
                                $html .= '<th class="text-left py-2 px-3 font-semibold">Date</th>';
                                $html .= '<th class="text-left py-2 px-3 font-semibold">Type</th>';
                                $html .= '<th class="text-right py-2 px-3 font-semibold">Coins</th>';
                                $html .= '<th class="text-left py-2 px-3 font-semibold">Remarks</th>';
                                $html .= '</tr></thead>';
                                $html .= '<tbody>';

                                foreach ($transactions as $transaction) {
                                    $badgeColor = $transaction->type === 'earned' ? 'text-green-600' : 'text-red-600';
                                    $prefix = $transaction->type === 'earned' ? '+' : '-';

                                    $html .= '<tr class="border-b border-gray-100">';
                                    $html .= '<td class="py-2 px-3">' . $transaction->created_at->format('d M Y, h:i A') . '</td>';
                                    $html .= '<td class="py-2 px-3">' . ucfirst($transaction->type) . '</td>';
                                    $html .= '<td class="py-2 px-3 text-right font-bold ' . $badgeColor . '">' . $prefix . number_format($transaction->points) . '</td>';
                                    $html .= '<td class="py-2 px-3 text-gray-600">' . ($transaction->remarks ?? 'N/A') . '</td>';
                                    $html .= '</tr>';
                                }

                                $html .= '</tbody></table>';
                                $html .= '</div>';


                                $totalEarned = $record->rewardTransactions()->where('type', 'earned')->sum('points');
                                $totalRedeemed = $record->rewardTransactions()->where('type', 'redeemed')->sum('points');
                                $available = $record->reward_points ?? 0;

                                $html .= '<div class="mt-4 p-3 bg-gray-50 rounded-lg grid grid-cols-3 gap-4">';
                                $html .= '<div><span class="text-sm text-gray-500">Total Earned</span><br><span class="font-bold text-green-600">' . number_format($totalEarned) . '</span></div>';
                                $html .= '<div><span class="text-sm text-gray-500">Total Redeemed</span><br><span class="font-bold text-red-600">' . number_format($totalRedeemed) . '</span></div>';
                                $html .= '<div><span class="text-sm text-gray-500">Available Coins</span><br><span class="font-bold text-blue-600">' . number_format($available) . '</span></div>';
                                $html .= '</div>';

                                return new HtmlString($html);
                            }),
                    ])
                    ->visible(fn($context) => $context === 'edit' && isset($record)),


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


                                Placeholder::make('coins_earned')
                                    ->label('Total Coins Earned')
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
