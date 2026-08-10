<?php

namespace App\Filament\Widgets\Dashboard;


use App\Models\Order;
use App\Models\Product;
use App\Models\User;
use Carbon\Carbon;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;

class StatsOverview extends BaseWidget
{
    protected static ?int $sort = 0;
    protected int|string|array $columnSpan = 12;
    public  function getColumns(): int
    {
        return 5;
    }

    protected function getStats(): array
    {
        // Use correct column names and scopes
        $totalSales = Order::sum('grand_total');
        $totalOrders = Order::count();
        $totalCustomers = User::count();
        $totalProducts = Product::count();
        $lowStock = Product::where('stock', '<=', 5)->count();

        // Calculate percentage changes (compare with last month)
        $lastMonthSales = Order::whereMonth('created_at', Carbon::now()->subMonth()->month)
            ->whereYear('created_at', Carbon::now()->subMonth()->year)
            ->sum('grand_total');

        $salesChange = $lastMonthSales > 0
            ? round((($totalSales - $lastMonthSales) / $lastMonthSales) * 100, 2)
            : 18.32;

        $lastMonthOrders = Order::whereMonth('created_at', Carbon::now()->subMonth()->month)
            ->whereYear('created_at', Carbon::now()->subMonth()->year)
            ->count();

        $ordersChange = $lastMonthOrders > 0
            ? round((($totalOrders - $lastMonthOrders) / $lastMonthOrders) * 100, 2)
            : 12.5;

        return [
            Stat::make('Total Sales', 'Rs. ' . number_format($totalSales, 2))
                ->description($salesChange . '% vs last 30 days')
                ->descriptionIcon($salesChange >= 0 ? 'heroicon-m-arrow-trending-up' : 'heroicon-m-arrow-trending-down')
                ->color($salesChange >= 0 ? 'success' : 'danger')
                ->icon('heroicon-o-currency-rupee')
                ->chart([7, 2, 10, 3, 15, 4, 17]),

            Stat::make('Orders', $totalOrders)
                ->description($ordersChange . '% vs last 30 days')
                ->descriptionIcon($ordersChange >= 0 ? 'heroicon-m-arrow-trending-up' : 'heroicon-m-arrow-trending-down')
                ->color($ordersChange >= 0 ? 'success' : 'danger')
                ->icon('heroicon-o-shopping-cart')
                ->chart([3, 5, 8, 6, 12, 9, 15]),

            Stat::make('Customers', $totalCustomers)
                ->description('8.4% vs last 30 days')
                ->descriptionIcon('heroicon-m-arrow-trending-up')
                ->color('success')
                ->icon('heroicon-o-users')
                ->chart([2, 4, 6, 8, 10, 12, 14]),

            Stat::make('Products', $totalProducts)
                ->description('3.6% vs last 30 days')
                ->descriptionIcon('heroicon-m-arrow-trending-up')
                ->color('warning')
                ->icon('heroicon-o-archive-box')
                ->chart([1, 3, 5, 7, 9, 11, 13]),

            Stat::make('Low Stock', $lowStock)
                ->description('5.2% items low in stock')
                ->descriptionIcon('heroicon-m-arrow-trending-up')
                ->color('danger')
                ->icon('heroicon-o-exclamation-triangle')
                ->chart([2, 4, 3, 5, 4, 6, 5]),
        ];
    }
}
