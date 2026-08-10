<?php

namespace App\Filament\Widgets\Customer;

use App\Models\Order;
use App\Models\User;
use Carbon\Carbon;
use Filament\Widgets\Concerns\InteractsWithPageFilters;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;

class CustomerStats extends BaseWidget
{
    use InteractsWithPageFilters;

    protected static ?int $sort = 1;

    protected function getStats(): array
    {
        [$start, $end] = $this->getRange();
        [$prevStart, $prevEnd] = $this->getPreviousRange($start, $end);

        // Total customers as of the end of the selected range vs as of the
        // end of the previous range (running total, not scoped to range).
        $totalCustomers = User::query()->where('created_at', '<=', $end)->count();
        $prevTotalCustomers = User::query()->where('created_at', '<=', $prevEnd)->count();

        // New signups within the range.
        $newCustomers = User::query()->whereBetween('created_at', [$start, $end])->count();
        $prevNewCustomers = User::query()->whereBetween('created_at', [$prevStart, $prevEnd])->count();

        // Customers who placed at least 1 order within the range.
        $activeCustomers = User::query()
            ->whereHas('orders', fn ($q) => $q->whereBetween('created_at', [$start, $end]))
            ->count();
        $prevActiveCustomers = User::query()
            ->whereHas('orders', fn ($q) => $q->whereBetween('created_at', [$prevStart, $prevEnd]))
            ->count();

        // Customers with 2+ orders within the range.
        $repeatCustomers = User::query()
            ->withCount(['orders' => fn ($q) => $q->whereBetween('created_at', [$start, $end])])
            ->having('orders_count', '>=', 2)
            ->count();
        $prevRepeatCustomers = User::query()
            ->withCount(['orders' => fn ($q) => $q->whereBetween('created_at', [$prevStart, $prevEnd])])
            ->having('orders_count', '>=', 2)
            ->count();

        $orders = Order::query()->where('order_status', '!=', 'cancelled')->whereBetween('created_at', [$start, $end]);
        $prevOrders = Order::query()->where('order_status', '!=', 'cancelled')->whereBetween('created_at', [$prevStart, $prevEnd]);

        $orderCount = (clone $orders)->count();
        $prevOrderCount = (clone $prevOrders)->count();

        $avgOrderValue = $orderCount > 0 ? (clone $orders)->sum('grand_total') / $orderCount : 0;
        $prevAvgOrderValue = $prevOrderCount > 0 ? (clone $prevOrders)->sum('grand_total') / $prevOrderCount : 0;

        return [
            Stat::make('Total Customers', number_format($totalCustomers))
                ->description($this->percentLabel($totalCustomers, $prevTotalCustomers))
                ->descriptionIcon($this->trendIcon($totalCustomers, $prevTotalCustomers))
                ->color($this->trendColor($totalCustomers, $prevTotalCustomers))
                ->icon('heroicon-o-users'),

            Stat::make('New Customers', number_format($newCustomers))
                ->description($this->percentLabel($newCustomers, $prevNewCustomers))
                ->descriptionIcon($this->trendIcon($newCustomers, $prevNewCustomers))
                ->color($this->trendColor($newCustomers, $prevNewCustomers))
                ->icon('heroicon-o-user-plus'),

            Stat::make('Active Customers', number_format($activeCustomers))
                ->description($this->percentLabel($activeCustomers, $prevActiveCustomers))
                ->descriptionIcon($this->trendIcon($activeCustomers, $prevActiveCustomers))
                ->color($this->trendColor($activeCustomers, $prevActiveCustomers))
                ->icon('heroicon-o-user-circle'),

            Stat::make('Repeat Customers', number_format($repeatCustomers))
                ->description($this->percentLabel($repeatCustomers, $prevRepeatCustomers))
                ->descriptionIcon($this->trendIcon($repeatCustomers, $prevRepeatCustomers))
                ->color($this->trendColor($repeatCustomers, $prevRepeatCustomers))
                ->icon('heroicon-o-arrow-path'),

            Stat::make('Avg. Order Value', 'Rs' . number_format($avgOrderValue, 2))
                ->description($this->percentLabel($avgOrderValue, $prevAvgOrderValue))
                ->descriptionIcon($this->trendIcon($avgOrderValue, $prevAvgOrderValue))
                ->color($this->trendColor($avgOrderValue, $prevAvgOrderValue))
                ->icon('heroicon-o-star'),
        ];
    }

    protected function getRange(): array
    {
        $start = isset($this->filters['startDate'])
            ? Carbon::parse($this->filters['startDate'])->startOfDay()
            : now()->subDays(90)->startOfDay();

        $end = isset($this->filters['endDate'])
            ? Carbon::parse($this->filters['endDate'])->endOfDay()
            : now()->endOfDay();

        return [$start, $end];
    }

    protected function getPreviousRange(Carbon $start, Carbon $end): array
    {
        $days = $start->diffInDays($end) + 1;

        return [
            (clone $start)->subDays($days),
            (clone $start)->subDay()->endOfDay(),
        ];
    }

    protected function percentLabel(float $current, float $previous): string
    {
        if ($previous == 0) {
            return $current > 0 ? '+100% from last period' : 'No change';
        }

        $change = (($current - $previous) / $previous) * 100;
        $direction = $change >= 0 ? '↑' : '↓';

        return sprintf('%s %.1f%% from last period', $direction, abs($change));
    }

    protected function trendIcon(float $current, float $previous): string
    {
        return $current >= $previous ? 'heroicon-m-arrow-trending-up' : 'heroicon-m-arrow-trending-down';
    }

    protected function trendColor(float $current, float $previous): string
    {
        return $current >= $previous ? 'success' : 'danger';
    }
}
