<?php

namespace App\Filament\Widgets\Dashboard;

use App\Models\Order;
use Carbon\Carbon;
use Filament\Widgets\ChartWidget;

class SalesOverviewChart extends ChartWidget
{
    protected static bool $isLazy = true;
    protected ?string $heading = 'Sales Overview';
    protected static ?int $sort = 1;
    protected ?string $maxHeight = '320px';

    protected int|string|array $columnSpan = [
        'default' => 1,
        'md' => 2,
        'xl' => 6,
    ];

    // Powers the dropdown button
    protected function getFilters(): ?array
    {
        return [
            'today'      => 'Today',
            'week'       => 'This Week',
            'month'      => 'This Month',
            'last_month' => 'Last Month',
            'year'       => 'This Year',
        ];
    }

    public ?string $filter = 'month';

    protected function getData(): array
    {
        [$dates, $salesData] = $this->getChartDataForFilter($this->filter ?? 'month');

        return [
            'datasets' => [
                [
                    'label' => 'Sales',
                    'data' => $salesData,
                    'fill' => true,
                    'borderColor' => '#6366f1',
                    'backgroundColor' => 'rgba(99,102,241,0.12)',
                    'tension' => 0.4,
                    'borderWidth' => 2.5,
                    'pointRadius' => 0,
                    'pointHoverRadius' => 6,
                    'pointHoverBackgroundColor' => '#6366f1',
                    'pointHoverBorderColor' => '#ffffff',
                    'pointHoverBorderWidth' => 2,
                    'pointHitRadius' => 20,
                ],
            ],
            'labels' => $dates,
        ];
    }

    protected function getChartDataForFilter(string $filter): array
    {
        [$start, $end, $groupBy] = $this->resolveRange($filter);

        $dates = [];
        $salesData = [];

        $period = match ($groupBy) {
            'hour'  => $this->buildHourlyRange($start, $end),
            'month' => $this->buildMonthlyRange($start, $end),
            default => $this->buildDailyRange($start, $end),
        };

        foreach ($period as $label => [$rangeStart, $rangeEnd]) {
            $dates[] = $label;

            $sum = Order::whereBetween('created_at', [$rangeStart, $rangeEnd])
                ->where('order_status', '!=', 'cancelled')
                ->sum('grand_total');

            $salesData[] = (float) $sum;
        }

        return [$dates, $salesData];
    }

    protected function resolveRange(string $filter): array
    {
        return match ($filter) {
            'today'      => [Carbon::today(), Carbon::today()->endOfDay(), 'hour'],
            'week'       => [Carbon::now()->startOfWeek(), Carbon::now()->endOfWeek(), 'day'],
            'last_month' => [Carbon::now()->subMonthNoOverflow()->startOfMonth(), Carbon::now()->subMonthNoOverflow()->endOfMonth(), 'day'],
            'year'       => [Carbon::now()->startOfYear(), Carbon::now()->endOfYear(), 'month'],
            default      => [Carbon::now()->startOfMonth(), Carbon::now()->endOfMonth(), 'day'],
        };
    }

    protected function buildHourlyRange(Carbon $start, Carbon $end): array
    {
        $period = [];
        $cursor = $start->copy();

        while ($cursor->lte($end)) {
            $label = $cursor->format('g A');
            $period[$label] = [$cursor->copy(), $cursor->copy()->addHour()->subSecond()];
            $cursor->addHour();
        }

        return $period;
    }

    protected function buildDailyRange(Carbon $start, Carbon $end): array
    {
        $period = [];
        $cursor = $start->copy();

        while ($cursor->lte($end)) {
            $label = $cursor->format('j M');
            $period[$label] = [$cursor->copy()->startOfDay(), $cursor->copy()->endOfDay()];
            $cursor->addDay();
        }

        return $period;
    }

    protected function buildMonthlyRange(Carbon $start, Carbon $end): array
    {
        $period = [];
        $cursor = $start->copy();

        while ($cursor->lte($end)) {
            $label = $cursor->format('M');
            $period[$label] = [$cursor->copy()->startOfMonth(), $cursor->copy()->endOfMonth()];
            $cursor->addMonth();
        }

        return $period;
    }

    protected function getType(): string
    {
        return 'line';
    }

    protected function getOptions(): array
    {
        return [
            'plugins' => [
                'legend' => [
                    'display' => false,
                ],
                'tooltip' => [
                    'enabled' => true,
                    'mode' => 'index',
                    'intersect' => false,
                    'backgroundColor' => '#ffffff',
                    'titleColor' => '#6b7280',
                    'bodyColor' => '#111827',
                    'titleFont' => ['size' => 12, 'weight' => 'normal'],
                    'bodyFont' => ['size' => 14, 'weight' => 'bold'],
                    'padding' => 12,
                    'cornerRadius' => 8,
                    'displayColors' => false,
                    'borderColor' => '#e5e7eb',
                    'borderWidth' => 1,
                    'caretSize' => 0,
                    'callbacks' => [
                        'label' => "function(context) {
                            return 'Rs. ' + context.parsed.y.toLocaleString();
                        }",
                    ],
                ],
            ],
            'interaction' => [
                'mode' => 'index',
                'intersect' => false,
            ],
            'scales' => [
                'x' => [
                    'grid' => ['display' => false],
                    'ticks' => [
                        'color' => '#9ca3af',
                        'font' => ['size' => 11],
                        'maxTicksLimit' => 7,
                        'autoSkip' => true,
                    ],
                    'border' => ['display' => false],
                ],
                'y' => [
                    'beginAtZero' => true,
                    'grid' => ['color' => '#f3f4f6', 'drawTicks' => false],
                    'border' => ['display' => false],
                    'ticks' => [
                        'color' => '#9ca3af',
                        'font' => ['size' => 11],
                        'callback' => "function(value) {
                            if (value === 0) return 'Rs. 0';
                            return 'Rs. ' + (value/1000) + 'K';
                        }",
                    ],
                ],
            ],
            'responsive' => true,
            'maintainAspectRatio' => false,
        ];
    }
}
