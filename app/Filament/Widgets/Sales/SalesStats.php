<?php

namespace App\Filament\Widgets\Sales;

use App\Models\Order;
use Carbon\Carbon;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;
use Filament\Widgets\Concerns\InteractsWithPageFilters;
use Illuminate\Support\Facades\DB;

class SalesStats extends BaseWidget
{
    use InteractsWithPageFilters;

    protected static ?int $sort = 1;
    protected int|string|array $columnSpan = 'full';

    protected ?string $heading = 'Sales Statistics';

    // Available date range filters
    protected array $dateRanges = [
        'today' => 'Today',
        'yesterday' => 'Yesterday',
        'week' => 'This Week',
        'month' => 'This Month',
        'quarter' => 'This Quarter',
        'year' => 'This Year',
        'custom' => 'Custom Range',
    ];

    public ?string $filter = 'month';

    protected function getStats(): array
    {
        [$start, $end] = $this->getRange();
        [$prevStart, $prevEnd] = $this->getPreviousRange($start, $end);

        $metrics = $this->getAllMetrics($start, $end, $prevStart, $prevEnd);

        return [
            $this->createStat(
                label: 'Total Sales',
                current: $metrics['current']['total_sales'],
                previous: $metrics['previous']['total_sales'],
                icon: 'heroicon-o-currency-dollar',
                color: 'success',
                format: 'currency'
            ),

            $this->createStat(
                label: 'Total Orders',
                current: $metrics['current']['total_orders'],
                previous: $metrics['previous']['total_orders'],
                icon: 'heroicon-o-shopping-bag',
                color: 'info',
                format: 'number'
            ),

            $this->createStat(
                label: 'Average Order Value',
                current: $metrics['current']['avg_order_value'],
                previous: $metrics['previous']['avg_order_value'],
                icon: 'heroicon-o-shopping-cart',
                color: 'warning',
                format: 'currency'
            ),

            $this->createStat(
                label: 'Refunds',
                current: $metrics['current']['refunds'],
                previous: $metrics['previous']['refunds'],
                icon: 'heroicon-o-tag',
                color: 'danger',
                format: 'currency'
            ),
        ];
    }

    protected function getAllMetrics(Carbon $start, Carbon $end, Carbon $prevStart, Carbon $prevEnd): array
    {
        $current = Order::query()
            ->whereBetween('created_at', [$start, $end])
            ->select([
                DB::raw('COUNT(*) as total_orders'),
                DB::raw('SUM(grand_total) as total_sales'),
                DB::raw('SUM(CASE WHEN payment_status = "refunded" THEN grand_total ELSE 0 END) as refunds'),
                DB::raw('SUM(discount) as total_discounts'),
            ])
            ->first();

        $previous = Order::query()
            ->whereBetween('created_at', [$prevStart, $prevEnd])
            ->select([
                DB::raw('COUNT(*) as total_orders'),
                DB::raw('SUM(grand_total) as total_sales'),
                DB::raw('SUM(CASE WHEN payment_status = "refunded" THEN grand_total ELSE 0 END) as refunds'),
                DB::raw('SUM(discount) as total_discounts'),
            ])
            ->first();

        $currentAvgOrder = ($current->total_orders ?? 0) > 0
            ? ($current->total_sales ?? 0) / ($current->total_orders ?? 0)
            : 0;

        $previousAvgOrder = ($previous->total_orders ?? 0) > 0
            ? ($previous->total_sales ?? 0) / ($previous->total_orders ?? 0)
            : 0;

        return [
            'current' => [
                'total_sales' => $current->total_sales ?? 0,
                'total_orders' => $current->total_orders ?? 0,
                'avg_order_value' => $currentAvgOrder,
                'refunds' => $current->refunds ?? 0,
            ],
            'previous' => [
                'total_sales' => $previous->total_sales ?? 0,
                'total_orders' => $previous->total_orders ?? 0,
                'avg_order_value' => $previousAvgOrder,
                'refunds' => $previous->refunds ?? 0,
            ]
        ];
    }

    protected function createStat(
        string $label,
        float $current,
        float $previous,
        string $icon,
        string $color = 'info',
        string $format = 'currency'
    ): Stat {
        $formattedValue = $this->formatValue($current, $format);
        $periodLabel = $this->getPeriodLabel();

        $stat = Stat::make($label, $formattedValue)
            ->icon($icon)
            ->color($color)
            ->description($this->getTrendDescription($current, $previous, $periodLabel))
            ->descriptionIcon($this->trendIcon($current, $previous))
            ->chart($this->getChartData($label))
            ->extraAttributes([
                'class' => 'transition-all duration-300 hover:scale-105',
            ]);

        return $stat;
    }

    protected function formatValue(float $value, string $format): string
    {
        return match($format) {
            'currency' => '$' . number_format($value, 2),
            'number' => number_format($value),
            'percentage' => number_format($value, 1) . '%',
            default => (string) $value,
        };
    }

    protected function getTrendDescription(float $current, float $previous, string $period): string
    {
        if ($previous == 0) {
            return $current > 0 ? '↑ 100% from ' . $period : 'No data from ' . $period;
        }

        $change = (($current - $previous) / $previous) * 100;
        $direction = $change >= 0 ? '↑' : '↓';
        $changeDisplay = number_format(abs($change), 1);

        return sprintf('%s %s%% from %s', $direction, $changeDisplay, $period);
    }

    protected function getPeriodLabel(): string
    {
        return match($this->filter) {
            'today' => 'yesterday',
            'yesterday' => 'previous day',
            'week' => 'last week',
            'month' => 'last month',
            'quarter' => 'last quarter',
            'year' => 'last year',
            default => 'previous period',
        };
    }

    protected function getChartData(string $label): array
    {
        // Generate sample chart data for visual representation
        // In production, you might want to fetch actual data
        $base = match($label) {
            'Total Sales' => 40000,
            'Total Orders' => 1200,
            'Average Order Value' => 35,
            'Refunds' => 1200,
            default => 1000,
        };

        return [
            $base * 0.8,
            $base * 0.9,
            $base * 1.1,
            $base * 1.0,
            $base * 1.2,
            $base * 1.3,
            $base * 1.1,
        ];
    }

    protected function getRange(): array
    {
        $filter = $this->filter ?? 'month';

        if ($filter === 'custom' && isset($this->filters['startDate']) && isset($this->filters['endDate'])) {
            return [
                Carbon::parse($this->filters['startDate'])->startOfDay(),
                Carbon::parse($this->filters['endDate'])->endOfDay(),
            ];
        }

        $now = now();

        return match($filter) {
            'today' => [
                $now->clone()->startOfDay(),
                $now->clone()->endOfDay(),
            ],
            'yesterday' => [
                $now->clone()->subDay()->startOfDay(),
                $now->clone()->subDay()->endOfDay(),
            ],
            'week' => [
                $now->clone()->startOfWeek(),
                $now->clone()->endOfWeek(),
            ],
            'quarter' => [
                $now->clone()->startOfQuarter(),
                $now->clone()->endOfQuarter(),
            ],
            'year' => [
                $now->clone()->startOfYear(),
                $now->clone()->endOfYear(),
            ],
            default => [
                $now->clone()->startOfMonth(),
                $now->clone()->endOfMonth(),
            ],
        };
    }

    protected function getPreviousRange(Carbon $start, Carbon $end): array
    {
        $days = $start->diffInDays($end) + 1;

        return [
            (clone $start)->subDays($days)->startOfDay(),
            (clone $start)->subDay()->endOfDay(),
        ];
    }

    protected function trendIcon(float $current, float $previous): string
    {
        if ($previous == 0) {
            return $current > 0 ? 'heroicon-m-arrow-trending-up' : 'heroicon-m-arrow-trending-down';
        }

        return $current >= $previous
            ? 'heroicon-m-arrow-trending-up'
            : 'heroicon-m-arrow-trending-down';
    }

    protected function getFilters(): ?array
    {
        return $this->dateRanges;
    }
}