<?php

namespace App\Filament\Widgets\Product;

use App\Models\Category;
use App\Models\OrderItem;
use Carbon\Carbon;
use Filament\Widgets\Concerns\InteractsWithPageFilters;
use Filament\Widgets\Widget;
use Illuminate\Support\Collection;

class SalesByCategory extends Widget
{
    use InteractsWithPageFilters;

    protected static ?string $heading = 'Sales by Category';
    protected static ?int $sort = 3;

    protected int|string|array $columnSpan = [
        'default' => 1,
        'md' => 2,
        'xl' => 12,
    ];

    protected string $view = 'filament.widgets.product.sales-by-category';


    public function getCategoryData(): Collection
    {

        $start = $this->dateRange['start'] ?? now()->startOfMonth();
        $end = $this->dateRange['end'] ?? now()->endOfMonth();

        $data = Category::query()
            ->select('categories.id', 'categories.name')
            ->selectSub(
                OrderItem::query()
                    ->join('products', 'products.id', '=', 'order_items.product_id')
                    ->join('orders', 'orders.id', '=', 'order_items.order_id')
                    ->whereColumn('products.category_id', 'categories.id')
                    ->whereBetween('orders.created_at', [$start, $end])
                    ->where('orders.order_status', '!=', 'cancelled')
                    ->selectRaw('COALESCE(SUM(order_items.quantity * order_items.price), 0)'),
                'revenue'
            )
            ->orderByDesc('revenue')
            ->limit(5)
            ->get();

        $total = $data->sum('revenue');

        $colors = [
            '#6366f1', '#3b82f6', '#22c55e', '#f59e0b', '#ef4444',
            '#8b5cf6', '#ec4899', '#14b8a6', '#f97316', '#8b5cf6'
        ];

        return $data->map(function ($category, $index) use ($total, $colors) {
            return (object) [
                'name' => $category->name,
                'revenue' => round((float) $category->revenue, 2),
                'percentage' => $total > 0 ? round(($category->revenue / $total) * 100, 1) : 0,
                'color' => $colors[$index % count($colors)],
            ];
        });
    }



    protected function getListeners(): array
    {
        return [
            'updateProductReport' => '$refresh',
        ];
    }
}
