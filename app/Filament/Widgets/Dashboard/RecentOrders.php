<?php

namespace App\Filament\Widgets\Dashboard;

use App\Filament\Resources\Orders\OrderResource;
use App\Models\Order;
use Filament\Actions\Action;
use Filament\Actions\ActionGroup;
use Filament\Notifications\Notification;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Filament\Widgets\TableWidget as BaseWidget;
use Illuminate\Database\Eloquent\Builder;

class RecentOrders extends BaseWidget
{
    protected static ?string $heading = 'Recent Orders';

    protected static ?int $sort = 4;

    protected int|string|array $columnSpan = [
        'default' => 1,
        'md' => 2,
        'xl' => 7,
    ];

    public function table(Table $table): Table
    {
        return $table
            ->query(
                fn (): Builder => Order::query()
                    ->with('user')
                    ->latest()
                    ->limit(5)
            )
            ->columns([
                TextColumn::make('order_number')
                    ->label('Order ID')
                    ->weight('bold')
                    ->color('primary')
                    ->formatStateUsing(fn ($state) => '#' . $state)
                    ->url(fn (Order $record) => OrderResource::getUrl('edit', ['record' => $record])),

                TextColumn::make('user.name')
                    ->label('Customer')
                    ->placeholder('Guest'),

                TextColumn::make('created_at')
                    ->label('Date')
                    ->formatStateUsing(fn ($state) => \Carbon\Carbon::parse($state)->format('d M, Y')),

                TextColumn::make('grand_total')
                    ->label('Total')
                    ->weight('bold')
                    ->formatStateUsing(fn ($state) => 'Rs. ' . number_format($state, 0)),

                TextColumn::make('order_status')
                    ->label('Status')
                    ->badge()
                    ->color(fn (string $state): string => match ($state) {
                        'delivered' => 'success',
                        'processing', 'shipped' => 'info',
                        'pending' => 'warning',
                        'cancelled' => 'danger',
                        default => 'gray',
                    })
                    ->formatStateUsing(fn (string $state): string => ucfirst($state)),

                TextColumn::make('payment_status')
                    ->label('Payment')
                    ->badge()
                    ->color(fn (string $state): string => match ($state) {
                        'paid' => 'success',
                        'failed' => 'danger',
                        'refunded' => 'gray',
                        default => 'warning',
                    })
                    ->formatStateUsing(fn (string $state): string => ucfirst($state)),
            ])
            ->headerActions([
                ActionGroup::make([
                    Action::make('viewAllOrders')
                        ->label('View All Orders')
                        ->icon('heroicon-o-list-bullet')
                        ->url(OrderResource::getUrl('index')),

                    Action::make('exportOrders')
                        ->label('Export Orders')
                        ->icon('heroicon-o-arrow-down-tray')
                        ->action(function () {
                            Notification::make()
                                ->title('Export started')
                                ->success()
                                ->send();
                        }),

                    Action::make('printOrders')
                        ->label('Print')
                        ->icon('heroicon-o-printer')
                        ->action(function () {
                            Notification::make()
                                ->title('Preparing print view')
                                ->success()
                                ->send();
                        }),
                ])
                ->label('View All Orders')
                ->icon('heroicon-m-chevron-down')
                ->iconPosition('after')
                ->color('gray')
                ->outlined()
                ->button(),
            ])
            ->paginated(false)
            ->defaultSort('created_at', 'desc')
            ->striped();
    }
}
