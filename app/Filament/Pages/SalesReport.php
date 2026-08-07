<?php

namespace App\Filament\Pages;

use App\Models\Order;
use App\Models\Product;
use BackedEnum;
use Carbon\Carbon;
use Filament\Actions\Action;
use Filament\Pages\Page;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\Select;
use Filament\Notifications\Notification;

class SalesReport extends Page
{
    protected static string|BackedEnum|null $navigationIcon = 'heroicon-o-chart-bar';
    protected string $view = 'filament.pages.sales-report';

    public static function getNavigationGroup(): string
    {
        return 'Reports & Analytics';
    }

    public static function getNavigationSort(): int
    {
        return 21;
    }

    protected static ?string $navigationLabel = 'Sales Report';
    protected static ?string $title = 'Sales Report';
    protected static ?string $slug = 'sales-report';

    public string $startDate;
    public string $endDate;
    public string $dateRange = 'this_month';
    public ?array $formData = [];

    public function mount(): void
    {
        $this->setDateRange('this_month');
        $this->formData = [
            'startDate' => $this->startDate,
            'endDate' => $this->endDate,
        ];
    }

    public function setDateRange(string $range): void
    {
        $this->dateRange = $range;

        switch ($range) {
            case 'today':
                $this->startDate = Carbon::today()->format('Y-m-d');
                $this->endDate = Carbon::today()->format('Y-m-d');
                break;
            case 'this_week':
                $this->startDate = Carbon::now()->startOfWeek()->format('Y-m-d');
                $this->endDate = Carbon::now()->endOfWeek()->format('Y-m-d');
                break;
            case 'this_month':
                $this->startDate = Carbon::now()->startOfMonth()->format('Y-m-d');
                $this->endDate = Carbon::now()->format('Y-m-d');
                break;
            case 'last_month':
                $this->startDate = Carbon::now()->subMonth()->startOfMonth()->format('Y-m-d');
                $this->endDate = Carbon::now()->subMonth()->endOfMonth()->format('Y-m-d');
                break;
            case 'this_year':
                $this->startDate = Carbon::now()->startOfYear()->format('Y-m-d');
                $this->endDate = Carbon::now()->format('Y-m-d');
                break;
            default:
                $this->startDate = Carbon::now()->startOfMonth()->format('Y-m-d');
                $this->endDate = Carbon::now()->format('Y-m-d');
        }
    }

    public function applyFilters(): void
    {
        $this->startDate = $this->formData['startDate'] ?? $this->startDate;
        $this->endDate = $this->formData['endDate'] ?? $this->endDate;
    }

    public function getViewData(): array
    {
        $start = Carbon::parse($this->startDate)->startOfDay();
        $end = Carbon::parse($this->endDate)->endOfDay();

        $orders = Order::whereBetween('created_at', [$start, $end])
            ->where('order_status', '!=', 'cancelled')
            ->get();

        $totalSales = $orders->sum('grand_total');
        $totalOrders = $orders->count();
        $averageOrder = $totalOrders > 0 ? $totalSales / $totalOrders : 0;
        $totalItemsSold = $orders->sum(function ($order) {
            return $order->items->sum('quantity') ?? 0;
        });
        $refunds = Order::whereBetween('created_at', [$start, $end])
            ->where('order_status', 'refunded')
            ->sum('grand_total');

        // Daily Sales Data
        $dailySales = Order::whereBetween('created_at', [$start, $end])
            ->where('order_status', '!=', 'cancelled')
            ->selectRaw('DATE(created_at) as date, SUM(grand_total) as total, COUNT(*) as count')
            ->groupBy('date')
            ->orderBy('date')
            ->get();

        // Payment Methods
        $paymentMethods = Order::whereBetween('created_at', [$start, $end])
            ->where('order_status', '!=', 'cancelled')
            ->selectRaw('payment_method, COUNT(*) as count, SUM(grand_total) as total')
            ->groupBy('payment_method')
            ->get();

        // Top Selling Products
        $topProducts = Product::select('products.id', 'products.name')
            ->join('order_items', 'products.id', '=', 'order_items.product_id')
            ->join('orders', 'order_items.order_id', '=', 'orders.id')
            ->whereBetween('orders.created_at', [$start, $end])
            ->where('orders.order_status', '!=', 'cancelled')
            ->selectRaw('SUM(order_items.quantity) as total_sold, SUM(order_items.total) as total_revenue')
            ->groupBy('products.id', 'products.name')
            ->orderBy('total_sold', 'desc')
            ->limit(5)
            ->get();

        // Previous Period Comparison
        $previousStart = (clone $start)->subMonth();
        $previousEnd = (clone $end)->subMonth();
        $previousOrders = Order::whereBetween('created_at', [$previousStart, $previousEnd])
            ->where('order_status', '!=', 'cancelled')
            ->get();
        $previousTotalSales = $previousOrders->sum('grand_total');
        $salesGrowth = $previousTotalSales > 0
            ? (($totalSales - $previousTotalSales) / $previousTotalSales) * 100
            : 0;

        return [
            'totalSales' => $totalSales,
            'totalOrders' => $totalOrders,
            'averageOrder' => $averageOrder,
            'totalItemsSold' => $totalItemsSold,
            'refunds' => $refunds,
            'orders' => $orders->take(10),
            'dailySales' => $dailySales,
            'paymentMethods' => $paymentMethods,
            'topProducts' => $topProducts,
            'salesGrowth' => $salesGrowth,
            'startDate' => $this->startDate,
            'endDate' => $this->endDate,
            'dateRange' => $this->dateRange,
        ];
    }

    protected function getHeaderActions(): array
    {
        return [
            Action::make('export')
                ->label('Export Report')
                ->icon('heroicon-o-arrow-down-tray')
                ->color('gray')
                ->action(function () {
                    Notification::make()
                        ->title('Report exported successfully')
                        ->success()
                        ->send();
                }),
        ];
    }
}
