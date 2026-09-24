<?php

namespace App\Filament\Widgets\Dashboard;

use App\Models\Order;
use Carbon\Carbon;
use Filament\Widgets\ChartWidget;

class OrdersByStatusChart extends ChartWidget
{
    protected ?string $heading = 'Orders by Status';
    protected static ?int $sort = 2;
    protected ?string $maxHeight = '320px';

    protected int|string|array $columnSpan = [
        'default' => 1,
        'md' => 2,
        'xl' => 6,
    ];

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
        [$start, $end] = $this->resolveRange($this->filter ?? 'month');

        $delivered = Order::delivered()
            ->whereBetween('created_at', [$start, $end])
            ->count();

        $processing = Order::processing()
            ->whereBetween('created_at', [$start, $end])
            ->count();

        $pending = Order::pending()
            ->whereBetween('created_at', [$start, $end])
            ->count();

        $cancelled = Order::cancelled()
            ->whereBetween('created_at', [$start, $end])
            ->count();

        // Shipped orders are grouped in with "Processing" for this chart.
        $shipped = Order::where('order_status', 'shipped')
            ->whereBetween('created_at', [$start, $end])
            ->count();

        $processing += $shipped;

        $total = $delivered + $processing + $pending + $cancelled;

        if ($total === 0) {
            return [
                'datasets' => [
                    [
                        'data' => [1],
                        'backgroundColor' => ['#e5e7eb'],
                        'borderColor' => ['#ffffff'],
                        'borderWidth' => 2,
                    ],
                ],
                'labels' => ['No orders in this period'],
            ];
        }

        $data = [$delivered, $processing, $pending, $cancelled];
        $labels = [
            "Delivered: " . round(($delivered / $total) * 100) . "% ($delivered)",
            "Processing: " . round(($processing / $total) * 100) . "% ($processing)",
            "Pending: " . round(($pending / $total) * 100) . "% ($pending)",
            "Cancelled: " . round(($cancelled / $total) * 100) . "% ($cancelled)",
        ];

        return [
            'datasets' => [
                [
                    'data' => $data,
                    'backgroundColor' => ['#6366f1', '#3b82f6', '#f59e0b', '#ef4444'],
                    'borderColor' => ['#ffffff', '#ffffff', '#ffffff', '#ffffff'],
                    'borderWidth' => 2,
                ],
            ],
            'labels' => $labels,
        ];
    }

    protected function resolveRange(string $filter): array
    {
        return match ($filter) {
            'today'      => [Carbon::today(), Carbon::today()->endOfDay()],
            'week'       => [Carbon::now()->startOfWeek(), Carbon::now()->endOfWeek()],
            'last_month' => [Carbon::now()->subMonthNoOverflow()->startOfMonth(), Carbon::now()->subMonthNoOverflow()->endOfMonth()],
            'year'       => [Carbon::now()->startOfYear(), Carbon::now()->endOfYear()],
            default      => [Carbon::now()->startOfMonth(), Carbon::now()->endOfMonth()],
        };
    }

    protected function getType(): string
    {
        return 'doughnut';
    }

    protected function getOptions(): array
    {
        return [
            'plugins' => [
                'legend' => [
                    'position' => 'bottom',
                    'labels' => [
                        'padding' => 15,
                        'usePointStyle' => true,
                        'pointStyle' => 'circle',
                        'font' => [
                            'size' => 12,
                        ],
                    ],
                ],
                'datalabels' => [
                    'display' => false,
                ],
            ],
            'cutout' => '55%',
            'responsive' => true,
            'maintainAspectRatio' => false,
        ];
    }

    public function getHeading(): string
    {
        return 'Orders by Status';
    }

    public function getSubheading(): ?string
    {
        return match ($this->filter ?? 'month') {
            'today'      => 'Today',
            'week'       => 'This Week',
            'last_month' => 'Last Month',
            'year'       => 'This Year',
            default      => 'This Month',
        };
    }
}
