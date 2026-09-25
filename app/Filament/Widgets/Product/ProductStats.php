<?php

namespace App\Filament\Widgets\Product;

use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Product;
use App\Models\Review;
use Carbon\Carbon;
use Filament\Widgets\Concerns\InteractsWithPageFilters;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;
use Illuminate\Support\Str;

class ProductStats extends BaseWidget
{
    use InteractsWithPageFilters;

    protected static ?int $sort = 1;
    protected static bool $isLazy = false;
    protected int|string|array $columnSpan = 'full';
    protected string $hoverClasses = 'transition-all duration-300 hover:scale-105';

    public ?array $filters = [];

    protected function getStats(): array
    {
        [$start, $end] = $this->getDateRange();

        $totalProducts = Product::count();
        $previousTotalProducts = Product::where('created_at', '<', $start)->count();
        $productGrowth = $this->calculateGrowth($totalProducts, $previousTotalProducts);

        $bestProduct = Product::query()
            ->withCount(['orderItems as sold' => function ($query) use ($start, $end) {
                $query->whereHas('order', function ($q) use ($start, $end) {
                    $q->whereBetween('created_at', [$start, $end])
                        ->where('order_status', '!=', 'cancelled');
                });
            }])
            ->orderByDesc('sold')
            ->first();

        // ✅ Best product name safely limit गर्नुहोस्
        $bestProductName = $bestProduct?->name ?? 'No Data';
        $truncatedName = Str::limit($bestProductName, 22, '…');
        $soldCount = $bestProduct->sold ?? 0;

        $totalSold = OrderItem::whereHas('order', function ($q) use ($start, $end) {
            $q->whereBetween('created_at', [$start, $end])
                ->where('order_status', '!=', 'cancelled');
        })->sum('quantity');

        $days = max(1, $start->diffInDays($end));
        $prevStart = (clone $start)->subDays($days + 1);
        $prevEnd = (clone $start)->subDay();

        $previousSold = OrderItem::whereHas('order', function ($q) use ($prevStart, $prevEnd) {
            $q->whereBetween('created_at', [$prevStart, $prevEnd])
                ->where('order_status', '!=', 'cancelled');
        })->sum('quantity');
        $soldGrowth = $this->calculateGrowth($totalSold, $previousSold);

        $totalRevenue = Order::whereBetween('created_at', [$start, $end])
            ->where('order_status', '!=', 'cancelled')
            ->sum('grand_total');

        $previousRevenue = Order::whereBetween('created_at', [$prevStart, $prevEnd])
            ->where('order_status', '!=', 'cancelled')
            ->sum('grand_total');
        $revenueGrowth = $this->calculateGrowth($totalRevenue, $previousRevenue);

        $avgRating = Review::whereBetween('created_at', [$start, $end])->avg('rating') ?? 0;
        $previousAvgRating = Review::whereBetween('created_at', [$prevStart, $prevEnd])->avg('rating') ?? 0;
        $ratingGrowth = $this->calculateGrowth($avgRating, $previousAvgRating);

        return [
            Stat::make('Total Products', number_format($totalProducts))
                ->description($this->formatGrowth($productGrowth))
                ->descriptionIcon($productGrowth >= 0 ? 'heroicon-m-arrow-trending-up' : 'heroicon-m-arrow-trending-down')
                ->color($productGrowth >= 0 ? 'success' : 'danger')
                ->icon('heroicon-o-cube')
                ->extraAttributes(['class' => $this->hoverClasses]),

            // ✅ Fixed: Truncated name + tooltip
            Stat::make('Best Selling Product', $truncatedName)
                ->description($soldCount . ' Sold')
                ->icon('heroicon-o-trophy')
                ->color('warning')
                ->extraAttributes([
                    'class' => $this->hoverClasses . ' cursor-help',
                    'title' => $bestProductName,
                ]),

            Stat::make('Total Units Sold', number_format($totalSold))
                ->description($this->formatGrowth($soldGrowth))
                ->descriptionIcon($soldGrowth >= 0 ? 'heroicon-m-arrow-trending-up' : 'heroicon-m-arrow-trending-down')
                ->color($soldGrowth >= 0 ? 'success' : 'danger')
                ->icon('heroicon-o-shopping-cart')
                ->extraAttributes(['class' => $this->hoverClasses]),

            Stat::make('Total Revenue', 'Rs. ' . number_format($totalRevenue, 2))
                ->description($this->formatGrowth($revenueGrowth))
                ->descriptionIcon($revenueGrowth >= 0 ? 'heroicon-m-arrow-trending-up' : 'heroicon-m-arrow-trending-down')
                ->color($revenueGrowth >= 0 ? 'success' : 'danger')
                ->icon('heroicon-o-currency-dollar')
                ->extraAttributes(['class' => $this->hoverClasses]),

            Stat::make('Avg. Rating', number_format($avgRating, 1) . ' / 5')
                ->description($this->formatGrowth($ratingGrowth))
                ->descriptionIcon($ratingGrowth >= 0 ? 'heroicon-m-arrow-trending-up' : 'heroicon-m-arrow-trending-down')
                ->color($ratingGrowth >= 0 ? 'success' : 'danger')
                ->icon('heroicon-o-star')
                ->extraAttributes(['class' => $this->hoverClasses]),
        ];
    }

    protected function formatGrowth($growth): string
    {
        $arrow = $growth >= 0 ? '↑ ' : '↓ ';
        return $arrow . number_format(abs($growth), 1) . '% from last month';
    }

    protected function getDateRange(): array
    {
        $startDate = $this->filters['startDate'] ?? null;
        $endDate = $this->filters['endDate'] ?? null;

        if ($startDate && $endDate) {
            return [
                Carbon::parse($startDate)->startOfDay(),
                Carbon::parse($endDate)->endOfDay(),
            ];
        }

        return [now()->startOfMonth(), now()->endOfMonth()];
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
