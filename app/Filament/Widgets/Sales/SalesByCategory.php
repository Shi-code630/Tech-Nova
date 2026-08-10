<?php

namespace App\Filament\Widgets\Sales;

use App\Models\Category;
use Carbon\Carbon;
use Filament\Widgets\ChartWidget;
use Filament\Widgets\Concerns\InteractsWithPageFilters;
use Illuminate\Support\Facades\DB;

class SalesByCategory extends ChartWidget
{
    use InteractsWithPageFilters;

    protected ?string $heading = 'Sales by Category';

    protected ?string $maxHeight = '320px';

    public ?string $filter = 'month';

    protected function getFilters(): ?array
    {
        return [
            'daily' => 'Daily',
            'weekly' => 'Weekly',
            'month' => 'This Month',
            'year' => 'This Year',
        ];
    }

    protected function getData(): array
    {
        $this->filter = $this->filter ?? 'month';
        $start = $this->filter === 'year'
            ? now()->startOfYear()
            : (isset($this->filters['startDate']) ? Carbon::parse($this->filters['startDate']) : now()->startOfMonth());

        $end = $this->filter === 'year'
            ? now()->endOfYear()
            : (isset($this->filters['endDate']) ? Carbon::parse($this->filters['endDate']) : now()->endOfMonth());

        // Join categories -> products -> order_items -> orders and sum revenue
        // per category within the selected date range. Adjust table/column
        // names here if your schema differs.
        $rows = Category::query()
            ->select('categories.id', 'categories.name')
            ->selectSub(
                DB::table('order_items')
                    ->join('products', 'products.id', '=', 'order_items.product_id')
                    ->join('orders', 'orders.id', '=', 'order_items.order_id')
                    ->whereColumn('products.category_id', 'categories.id')
                    ->whereBetween('orders.created_at', [$start, $end])
                    ->selectRaw('COALESCE(SUM(order_items.quantity * order_items.price), 0)'),
                'revenue'
            )
            ->orderByDesc('revenue')
            ->get();

        return [
            'datasets' => [
                [
                    'label' => 'Revenue',
                    'data' => $rows->pluck('revenue')->map(fn($v) => round($v ?? 0, 2))->all(),
                    'backgroundColor' => '#6366f1',
                    'borderRadius' => 6,
                    'barThickness' => 28,
                ],
            ],
            'labels' => $rows->pluck('name')->all(),
        ];
    }

    protected function getType(): string
    {
        return 'bar';
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
