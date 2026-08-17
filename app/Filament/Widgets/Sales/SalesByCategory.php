<?php

namespace App\Filament\Widgets\Sales;

use App\Models\Category;
use App\Models\OrderItem;
use App\Models\Product;
use Carbon\Carbon;
use Filament\Widgets\Concerns\InteractsWithPageFilters;
use Filament\Widgets\Widget;
use Illuminate\Support\Facades\DB;

class SalesByCategory extends Widget
{
    use InteractsWithPageFilters;

    protected static ?int $sort = 3;
    protected int|string|array $columnSpan = 'full';
    protected static ?string $heading = 'Sales by Category';

    protected string $view = 'filament.widgets.sales.sales-by-category';
    public ?string $filter = 'month';

    protected function getFilters(): ?array
    {
        return [
            'today' => 'Today',
            'week' => 'This Week',
            'month' => 'This Month',
            'quarter' => 'This Quarter',
            'year' => 'This Year',
        ];
    }

    public function getCategorySalesData(): array
    {
        [$start, $end] = $this->getDateRange();


        $categorySales = Category::query()
            ->select(
                'categories.id',
                'categories.name',
                'categories.slug',
                DB::raw('COALESCE(SUM(order_items.total), 0) as total_sales'),
                DB::raw('COUNT(DISTINCT order_items.order_id) as order_count'),
                DB::raw('COALESCE(SUM(order_items.quantity), 0) as total_items_sold')
            )
            ->leftJoin('products', 'products.category_id', '=', 'categories.id')
            ->leftJoin('order_items', 'order_items.product_id', '=', 'products.id')
            ->leftJoin('orders', 'orders.id', '=', 'order_items.order_id')
            ->where(function ($query) use ($start, $end) {
                if ($start && $end) {
                    $query->whereBetween('orders.created_at', [$start, $end]);
                }
               
            })
            ->groupBy('categories.id', 'categories.name', 'categories.slug')
            ->orderByDesc('total_sales')
            ->get();


        $totalSales = $categorySales->sum('total_sales');


        $labels = [];
        $data = [];
        $colors = [
            '#6366f1',
            '#8b5cf6',
            '#ec4899',
            '#f59e0b',
            '#10b981',
            '#3b82f6',
            '#ef4444',
            '#14b8a6',
            '#f97316',
            '#8b5cf6',
        ];

        $formattedData = [];
        $index = 0;

        foreach ($categorySales as $category) {
            $percentage = $totalSales > 0 ? round(($category->total_sales / $totalSales) * 100, 1) : 0;

            $formattedData[] = [
                'id' => $category->id,
                'name' => $category->name,
                'slug' => $category->slug,
                'total_sales' => $category->total_sales,
                'order_count' => $category->order_count,
                'total_items_sold' => $category->total_items_sold,
                'percentage' => $percentage,
                'color' => $colors[$index % count($colors)],
                'formatted_sales' => 'Rs. ' . number_format($category->total_sales, 2),
            ];
            $index++;
        }


        if ($categorySales->isEmpty()) {
            return [
                'labels' => ['No Data'],
                'data' => [0],
                'colors' => ['#e5e7eb'],
                'categories' => [],
                'total_sales' => 0,
            ];
        }

        return [
            'labels' => $categorySales->pluck('name')->toArray(),
            'data' => $categorySales->pluck('total_sales')->toArray(),
            'colors' => array_slice($colors, 0, $categorySales->count()),
            'categories' => $formattedData,
            'total_sales' => $totalSales,
        ];
    }

    public function getCategoryIcon(string $categoryName): string
    {
        $icons = [
            'Electronics' => 'heroicon-o-device-phone-mobile',
            'Fashion' => 'heroicon-o-swatch',
            'Home & Kitchen' => 'heroicon-o-home',
            'Beauty' => 'heroicon-o-sparkles',
            'Sports' => 'heroicon-o-trophy',
            'Books' => 'heroicon-o-book-open',
            'Computers' => 'heroicon-o-computer-desktop',
            'Mobile & Tablets' => 'heroicon-o-device-phone-mobile',
            'Gaming & Entertainment' => 'heroicon-o-play',
            'Home Appliances' => 'heroicon-o-home-modern',
            'Smart Home' => 'heroicon-o-cpu-chip',
            'Electrical' => 'heroicon-o-bolt',
        ];


        if (isset($icons[$categoryName])) {
            return $icons[$categoryName];
        }


        foreach ($icons as $key => $icon) {
            if (str_contains($categoryName, $key) || str_contains($key, $categoryName)) {
                return $icon;
            }
        }

        return 'heroicon-o-tag';
    }

    protected function getDateRange(): array
    {
        $filter = $this->filter ?? 'month';

        $now = now();

        return match($filter) {
            'today' => [
                $now->clone()->startOfDay(),
                $now->clone()->endOfDay(),
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

    protected function getListeners(): array
    {
        return [
            'updateWidget' => '$refresh',
        ];
    }
}
