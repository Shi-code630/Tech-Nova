<?php

namespace App\Filament\Widgets\Product;

use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Product;
use App\Models\Review;
use Carbon\Carbon;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;
use Filament\Widgets\Concerns\InteractsWithPageFilters;

class ProductStats extends BaseWidget
{
    use InteractsWithPageFilters;

    protected static ?int $sort = 1;
    protected static bool $isLazy = false;
    protected int|string|array $columnSpan = 'full';

    public ?array $filters = [];

    protected function getStats(): array
    {
        [$start, $end] = $this->getDateRange();

        // Total Products
        $totalProducts = Product::count();
        $previousTotalProducts = Product::where('created_at', '<', $start)->count();
        $productGrowth = $this->calculateGrowth($totalProducts, $previousTotalProducts);

        // Best Selling Product
        $bestProduct = Product::query()
            ->withCount(['orderItems as sold' => function ($query) use ($start, $end) {
                $query->whereHas('order', function ($q) use ($start, $end) {
                    $q->whereBetween('created_at', [$start, $end])
                      ->where('order_status', '!=', 'cancelled');
                });
            }])
            ->orderByDesc('sold')
            ->first();

        // Total Units Sold
        $totalSold = OrderItem::whereHas('order', function ($q) use ($start, $end) {
            $q->whereBetween('created_at', [$start, $end])
              ->where('order_status', '!=', 'cancelled');
        })->sum('quantity');

        $previousSold = OrderItem::whereHas('order', function ($q) use ($start, $end) {
            $days = $start->diffInDays($end);
            $prevStart = (clone $start)->subDays($days + 1);
            $prevEnd = (clone $start)->subDay();
            $q->whereBetween('created_at', [$prevStart, $prevEnd])
              ->where('order_status', '!=', 'cancelled');
        })->sum('quantity');
        $soldGrowth = $this->calculateGrowth($totalSold, $previousSold);

        // Total Revenue
        $totalRevenue = Order::whereBetween('created_at', [$start, $end])
            ->where('order_status', '!=', 'cancelled')
            ->sum('grand_total');

        $previousRevenue = Order::whereBetween('created_at', [$this->getPreviousStart($start), $this->getPreviousEnd($start)])
            ->where('order_status', '!=', 'cancelled')
            ->sum('grand_total');
        $revenueGrowth = $this->calculateGrowth($totalRevenue, $previousRevenue);

        // Average Rating
        $avgRating = Review::whereBetween('created_at', [$start, $end])
            ->avg('rating') ?? 0;

        $previousAvgRating = Review::whereBetween('created_at', [$this->getPreviousStart($start), $this->getPreviousEnd($start)])
            ->avg('rating') ?? 0;
        $ratingGrowth = $this->calculateGrowth($avgRating, $previousAvgRating);

        return [
            Stat::make('Total Products', number_format($totalProducts))
                ->description(($productGrowth >= 0 ? '↑ ' : '↓ ') . number_format(abs($productGrowth), 1) . '% from last month')
                ->descriptionIcon($productGrowth >= 0 ? 'heroicon-m-arrow-trending-up' : 'heroicon-m-arrow-trending-down')
                ->color($productGrowth >= 0 ? 'success' : 'danger')
                ->icon('heroicon-o-cube')
                ->chart([3, 5, 2, 4, 6, 8, 7]),

            Stat::make('Best Selling Product', $bestProduct ? $bestProduct->name : 'No Data')
                ->description(($bestProduct ? $bestProduct->sold : 0) . ' Sold')
                ->icon('heroicon-o-trophy')
                ->color('warning'),

            Stat::make('Total Units Sold', number_format($totalSold))
                ->description(($soldGrowth >= 0 ? '↑ ' : '↓ ') . number_format(abs($soldGrowth), 1) . '% from last month')
                ->descriptionIcon($soldGrowth >= 0 ? 'heroicon-m-arrow-trending-up' : 'heroicon-m-arrow-trending-down')
                ->color($soldGrowth >= 0 ? 'success' : 'danger')
                ->icon('heroicon-o-shopping-cart')
                ->chart([4, 6, 3, 7, 5, 9, 8]),

            Stat::make('Total Revenue', '$' . number_format($totalRevenue, 2))
                ->description(($revenueGrowth >= 0 ? '↑ ' : '↓ ') . number_format(abs($revenueGrowth), 1) . '% from last month')
                ->descriptionIcon($revenueGrowth >= 0 ? 'heroicon-m-arrow-trending-up' : 'heroicon-m-arrow-trending-down')
                ->color($revenueGrowth >= 0 ? 'success' : 'danger')
                ->icon('heroicon-o-currency-dollar')
                ->chart([5, 7, 4, 8, 6, 10, 9]),

            Stat::make('Avg. Rating', number_format($avgRating, 1) . ' / 5')
                ->description(($ratingGrowth >= 0 ? '↑ ' : '↓ ') . number_format(abs($ratingGrowth), 1) . '% from last month')
                ->descriptionIcon($ratingGrowth >= 0 ? 'heroicon-m-arrow-trending-up' : 'heroicon-m-arrow-trending-down')
                ->color($ratingGrowth >= 0 ? 'success' : 'danger')
                ->icon('heroicon-o-star')
                ->chart([4, 4.5, 4.2, 4.6, 4.4, 4.7, 4.6]),
        ];
    }

    protected function getDateRange(): array
    {
        $startDate = $this->filters['startDate'] ?? null;
        $endDate = $this->filters['endDate'] ?? null;

        if ($startDate && $endDate) {
            return [
                Carbon::parse($startDate)->startOfDay(),
                Carbon::parse($endDate)->endOfDay()
            ];
        }

        return [
            now()->startOfMonth(),
            now()->endOfMonth()
        ];
    }

    protected function getPreviousStart($start): Carbon
    {
        $days = $start->diffInDays(now()->endOfMonth());
        return (clone $start)->subDays($days + 1);
    }

    protected function getPreviousEnd($start): Carbon
    {
        return (clone $start)->subDay()->endOfDay();
    }

    protected function calculateGrowth($current, $previous): float
    {
        if ($previous == 0 || $previous == null) {
            return $current > 0 ? 100 : 0;
        }
        return (($current - $previous) / abs($previous)) * 100;
    }

    protected function getColumns(): int
    {
        return 5;
    }
}
