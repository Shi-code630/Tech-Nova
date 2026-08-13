<?php

namespace App\Filament\Widgets\Sales;

use App\Models\Order;
use Carbon\Carbon;
use Carbon\CarbonPeriod;
use Filament\Widgets\Concerns\InteractsWithPageFilters;
use Filament\Widgets\Widget;

class SalesOverviewChart extends Widget
{
    use InteractsWithPageFilters;

    protected static ?int $sort = 2;
    protected int|string|array $columnSpan = [
        'default' => 1,
        'md' => 2,
        'xl' => 7,
    ];
    protected static ?string $heading = 'Sales Overview';

    protected string $view = 'filament.widgets.sales.sales-overview-chart';

    public ?string $filter = 'daily';


    protected function getFilterOptions(): ?array
    {
        return [
            'daily' => 'Daily',
            'weekly' => 'Weekly',
            'monthly' => 'Monthly',
            'yearly' => 'Yearly',
        ];
    }

     public function getDateRangeLabel(): array
    {
        [$start, $end] = $this->getDateRange();

        return [
            'from' => $start->format('M d, Y'),
            'to' => $end->format('M d, Y'),
        ];
    }

    public function getChartData(): array
    {
        [$start, $end] = $this->getDateRange();


        switch($this->filter) {
            case 'weekly':
                $start = Carbon::parse($start)->startOfWeek();
                $end = Carbon::parse($end)->endOfWeek();
                break;
            case 'monthly':
                $start = Carbon::parse($start)->startOfMonth();
                $end = Carbon::parse($end)->endOfMonth();
                break;
            case 'yearly':
                $start = Carbon::parse($start)->startOfYear();
                $end = Carbon::parse($end)->endOfYear();
                break;
        }

        $orders = Order::query()
            ->whereBetween('created_at', [$start, $end])
            ->get();

        if ($orders->isEmpty()) {
            return [
                'labels' => ['No Data'],
                'data' => [0],
                'max_value' => 10000,
                'current_filter' => $this->filter,
            ];
        }

        // Group data based on filter
        $groupedData = $orders->groupBy(function ($order) {
            return match($this->filter) {
                'weekly' => $order->created_at->startOfWeek()->format('Y-m-d'),
                'monthly' => $order->created_at->format('Y-m'),
                'yearly' => $order->created_at->format('Y'),
                default => $order->created_at->format('Y-m-d'),
            };
        });

        $period = CarbonPeriod::create($start, $end);

        $labels = [];
        $totals = [];

        foreach ($period as $date) {
            $key = match($this->filter) {
                'weekly' => $date->startOfWeek()->format('Y-m-d'),
                'monthly' => $date->format('Y-m'),
                'yearly' => $date->format('Y'),
                default => $date->format('Y-m-d'),
            };

            $labels[] = match($this->filter) {
                'weekly' => 'Week ' . $date->weekOfYear . ' (' . $date->startOfWeek()->format('M d') . ')',
                'monthly' => $date->format('M Y'),
                'yearly' => $date->format('Y'),
                default => $date->format('M d, Y'),
            };

            $total = $groupedData->get($key);
            $totals[] = $total ? round($total->sum('grand_total'), 2) : 0;
        }

        $maxValue = max($totals) > 0 ? max($totals) : 10000;
        $roundedMax = ceil($maxValue / 1000) * 1000;

        return [
            'labels' => $labels,
            'data' => $totals,
            'max_value' => $roundedMax,
            'current_filter' => $this->filter,
        ];
    }

    protected function getDateRange(): array
    {

        $filter = $this->filter ?? 'daily';
        $now = now();

        return match($filter) {
            'daily' => [
                $now->clone()->startOfDay()->subDays(30), // Last 30 days
                $now->clone()->endOfDay(),
            ],
            'weekly' => [
                $now->clone()->startOfWeek()->subWeeks(12), // Last 12 weeks
                $now->clone()->endOfWeek(),
            ],
            'monthly' => [
                $now->clone()->startOfMonth()->subMonths(12), // Last 12 months
                $now->clone()->endOfMonth(),
            ],
            'yearly' => [
                $now->clone()->startOfYear()->subYears(5), // Last 5 years
                $now->clone()->endOfYear(),
            ],
            default => [
                $now->clone()->startOfMonth()->subMonths(6),
                $now->clone()->endOfMonth(),
            ],
        };
    }

    protected function getListeners(): array
    {
        return [
            'updateWidget' => '$refresh',
        ];
    }
}
