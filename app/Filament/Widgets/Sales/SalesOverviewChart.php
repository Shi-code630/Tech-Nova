<?php

namespace App\Filament\Widgets\Sales;

use App\Models\Order;
use Carbon\Carbon;
use Carbon\CarbonPeriod;
use Filament\Widgets\ChartWidget;
use Filament\Widgets\Concerns\InteractsWithPageFilters;

class SalesOverviewChart extends ChartWidget
{
    use InteractsWithPageFilters;

    protected ?string $heading = 'Sales Overview';

    protected ?string $maxHeight = '320px';

    public ?string $filter = 'daily';

    protected function getFilters(): ?array
    {
        return [
            'daily' => 'Daily',
            'weekly' => 'Weekly',
        ];
    }

    protected function getData(): array
    {
        $start = isset($this->filters['startDate'])
            ? Carbon::parse($this->filters['startDate'])->startOfDay()
            : now()->startOfMonth();

        $end = isset($this->filters['endDate'])
            ? Carbon::parse($this->filters['endDate'])->endOfDay()
            : now()->endOfMonth();

        $interval = $this->filter === 'weekly' ? '1 week' : '1 day';

        $period = CarbonPeriod::create($start, $interval, $end);

        $orders = Order::query()
            ->whereBetween('created_at', [$start, $end])
            ->get()
            ->groupBy(function ($order) {
                return $this->filter === 'weekly'
                    ? $order->created_at->startOfWeek()->format('Y-m-d')
                    : $order->created_at->format('Y-m-d');
            });

        $labels = [];
        $totals = [];

        foreach ($period as $date) {
            $key = $this->filter === 'weekly'
                ? $date->startOfWeek()->format('Y-m-d')
                : $date->format('Y-m-d');

            $labels[] = $date->format('M d');
            $totals[] = round(optional($orders->get($key))->sum('grand_total') ?? 0, 2);
        }

        return [
            'datasets' => [
                [
                    'label' => 'Sales',
                    'data' => $totals,
                    'borderColor' => '#6366f1',
                    'backgroundColor' => 'rgba(99, 102, 241, 0.15)',
                    'fill' => true,
                    'tension' => 0.4,
                    'pointRadius' => 3,
                ],
            ],
            'labels' => $labels,
        ];
    }

    protected function getType(): string
    {
        return 'line';
    }

    protected function getOptions(): array
    {
        return [
            'plugins' => [
                'legend' => ['display' => false],
            ],
            'scales' => [
                'y' => [
                    'ticks' => [
                        'callback' => "function (value) { return '$' + value; }",
                    ],
                ],
            ],
        ];
    }
}
