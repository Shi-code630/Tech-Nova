<?php

namespace App\Filament\Widgets\Sales;

use App\Models\Order;
use Carbon\Carbon;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;
use Filament\Widgets\Concerns\InteractsWithPageFilters;

class SalesStats extends BaseWidget
{
    use InteractsWithPageFilters;

    protected function getStats(): array
    {
        [$start, $end] = $this->getRange();
        [$prevStart, $prevEnd] = $this->getPreviousRange($start, $end);

        $current = Order::query()->whereBetween('created_at', [$start, $end]);
        $previous = Order::query()->whereBetween('created_at', [$prevStart, $prevEnd]);

        $totalSales = (clone $current)->sum('grand_total');
        $prevTotalSales = (clone $previous)->sum('grand_total');

        $totalOrders = (clone $current)->count();
        $prevTotalOrders = (clone $previous)->count();

        $avgOrderValue = $totalOrders > 0 ? $totalSales / $totalOrders : 0;
        $prevAvgOrderValue = $prevTotalOrders > 0 ? $prevTotalSales / $prevTotalOrders : 0;

        $refunds = (clone $current)->where('payment_status', 'refunded')->sum('grand_total');
        $prevRefunds = (clone $previous)->where('payment_status', 'refunded')->sum('grand_total');

        return [
            Stat::make('Total Sales', '$' . number_format($totalSales, 2))
                ->description($this->percentLabel($totalSales, $prevTotalSales))
                ->descriptionIcon($this->trendIcon($totalSales, $prevTotalSales))
                ->color($this->trendColor($totalSales, $prevTotalSales))
                ->icon('heroicon-o-currency-dollar'),

            Stat::make('Total Orders', number_format($totalOrders))
                ->description($this->percentLabel($totalOrders, $prevTotalOrders))
                ->descriptionIcon($this->trendIcon($totalOrders, $prevTotalOrders))
                ->color($this->trendColor($totalOrders, $prevTotalOrders))
                ->icon('heroicon-o-shopping-bag'),

            Stat::make('Average Order Value', '$' . number_format($avgOrderValue, 2))
                ->description($this->percentLabel($avgOrderValue, $prevAvgOrderValue))
                ->descriptionIcon($this->trendIcon($avgOrderValue, $prevAvgOrderValue))
                ->color($this->trendColor($avgOrderValue, $prevAvgOrderValue))
                ->icon('heroicon-o-shopping-cart'),

            Stat::make('Refunds', '$' . number_format($refunds, 2))
                ->description($this->percentLabel($refunds, $prevRefunds, invert: true))
                ->descriptionIcon($this->trendIcon($refunds, $prevRefunds, invert: true))
                ->color($this->trendColor($refunds, $prevRefunds, invert: true))
                ->icon('heroicon-o-tag'),
        ];
    }

    protected function getRange(): array
    {
        $start = isset($this->filters['startDate'])
            ? Carbon::parse($this->filters['startDate'])->startOfDay()
            : now()->startOfMonth();

        $end = isset($this->filters['endDate'])
            ? Carbon::parse($this->filters['endDate'])->endOfDay()
            : now()->endOfMonth();

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

    protected function percentLabel(float $current, float $previous, bool $invert = false): string
    {
        if ($previous == 0) {
            return $current > 0 ? '+100% from last period' : 'No change';
        }

        $change = (($current - $previous) / $previous) * 100;
        $direction = $change >= 0 ? '↑' : '↓';

        return sprintf('%s %.1f%% from last period', $direction, abs($change));
    }

    protected function trendIcon(float $current, float $previous, bool $invert = false): string
    {
        $up = $current >= $previous;

        if ($invert) {
            $up = ! $up;
        }

        return $up ? 'heroicon-m-arrow-trending-up' : 'heroicon-m-arrow-trending-down';
    }

    protected function trendColor(float $current, float $previous, bool $invert = false): string
    {
        $good = $current >= $previous;

        if ($invert) {
            $good = ! $good;
        }

        return $good ? 'success' : 'danger';
    }
}
