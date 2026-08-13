<?php

namespace App\Filament\Widgets\Sales;

use App\Models\Order;
use Carbon\Carbon;
use Filament\Widgets\Concerns\InteractsWithPageFilters;
use Filament\Widgets\Widget;
use Illuminate\Support\Facades\DB;

class SalesByPaymentMethod extends Widget
{
    use InteractsWithPageFilters;

    protected static ?int $sort = 4;

    protected static ?string $heading = 'Sales by Payment Method';
     protected int|string|array $columnSpan = [
        'default' => 1,
        'md' => 2,
        'xl' => 5,
    ];

      protected string $view = 'filament.widgets.sales.sales-by-payment-method';

    public ?string $filter = 'today';


    protected function getFilterOptions(): ?array
    {
        return [
            'today' => 'Today',
            'week' => 'This Week',
            'month' => 'This Month',
            'quarter' => 'This Quarter',
            'year' => 'This Year',
        ];
    }

    public function getPaymentMethodData(): array
    {
        [$start, $end] = $this->getDateRange();


        $paymentData = Order::query()
            ->select(
                'payment_method',
                DB::raw('COALESCE(SUM(grand_total), 0) as total_sales'),
                DB::raw('COUNT(*) as order_count')
            )
            ->whereBetween('created_at', [$start, $end])
            ->whereNotNull('payment_method')
            ->groupBy('payment_method')
            ->orderByDesc('total_sales')
            ->get();

        $totalSales = $paymentData->sum('total_sales');


        $paymentMethods = [
            'esewa' => [
                'label' => 'eSewa',
                'icon' => 'heroicon-o-credit-card',
                'color' => '#6366f1',
                'bg_color' => 'bg-indigo-50 dark:bg-indigo-500/10',
                'text_color' => 'text-indigo-600 dark:text-indigo-400',
            ],
            'khalti' => [
                'label' => 'Khalti',
                'icon' => 'heroicon-o-wallet',
                'color' => '#8b5cf6',
                'bg_color' => 'bg-purple-50 dark:bg-purple-500/10',
                'text_color' => 'text-purple-600 dark:text-purple-400',
            ],
            'visa' => [
                'label' => 'Visa',
                'icon' => 'heroicon-o-credit-card',
                'color' => '#3b82f6',
                'bg_color' => 'bg-blue-50 dark:bg-blue-500/10',
                'text_color' => 'text-blue-600 dark:text-blue-400',
            ],
            'cod' => [
                'label' => 'Cash on Delivery',
                'icon' => 'heroicon-o-banknotes',
                'color' => '#10b981',
                'bg_color' => 'bg-green-50 dark:bg-green-500/10',
                'text_color' => 'text-green-600 dark:text-green-400',
            ],
            'bank' => [
                'label' => 'Bank Transfer',
                'icon' => 'heroicon-o-building-library',
                'color' => '#f59e0b',
                'bg_color' => 'bg-amber-50 dark:bg-amber-500/10',
                'text_color' => 'text-amber-600 dark:text-amber-400',
            ],
            'mobile_banking' => [
                'label' => 'Mobile Banking',
                'icon' => 'heroicon-o-device-phone-mobile',
                'color' => '#ec4899',
                'bg_color' => 'bg-pink-50 dark:bg-pink-500/10',
                'text_color' => 'text-pink-600 dark:text-pink-400',
            ],
        ];

        $formattedData = [];
        $colors = [];
        $labels = [];
        $data = [];

        foreach ($paymentData as $index => $payment) {
            $method = strtolower(trim($payment->payment_method));


            $displayName = match($method) {
                'esewa' => 'eSewa',
                'khalti' => 'Khalti',
                'visa', 'visa_card', 'mastercard', 'credit_card' => 'Credit Card',
                'cod', 'cash_on_delivery' => 'Cash on Delivery',
                'bank', 'bank_transfer' => 'Bank Transfer',
                'mobile_banking' => 'Mobile Banking',
                default => ucfirst($method),
            };

            $percentage = $totalSales > 0 ? round(($payment->total_sales / $totalSales) * 100, 1) : 0;
            $methodConfig = $paymentMethods[$method] ?? [
                'label' => $displayName,
                'icon' => 'heroicon-o-credit-card',
                'color' => '#6b7280',
                'bg_color' => 'bg-gray-50 dark:bg-gray-500/10',
                'text_color' => 'text-gray-600 dark:text-gray-400',
            ];

            $formattedData[] = [
                'method' => $displayName,
                'total_sales' => $payment->total_sales,
                'order_count' => $payment->order_count,
                'percentage' => $percentage,
                'color' => $methodConfig['color'],
                'bg_color' => $methodConfig['bg_color'],
                'text_color' => $methodConfig['text_color'],
                'icon' => $methodConfig['icon'],
                'formatted_sales' => 'Rs. ' . number_format($payment->total_sales, 2),
            ];

            $labels[] = $displayName;
            $data[] = $payment->total_sales;
            $colors[] = $methodConfig['color'];
        }

        if ($paymentData->isEmpty()) {
            return [
                'labels' => ['No Data'],
                'data' => [0],
                'colors' => ['#e5e7eb'],
                'payment_methods' => [],
                'total_sales' => 0,
            ];
        }

        return [
            'labels' => $labels,
            'data' => $data,
            'colors' => $colors,
            'payment_methods' => $formattedData,
            'total_sales' => $totalSales,
        ];
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
