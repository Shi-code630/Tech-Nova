<?php

namespace App\Filament\Widgets\Sales;

use App\Models\Order;
use Carbon\Carbon;
use Filament\Widgets\Concerns\InteractsWithPageFilters;
use Filament\Widgets\Widget;
use Illuminate\Support\Collection;

class PaymentMethodChart extends Widget
{
    use InteractsWithPageFilters;

    protected static ?int $sort = 2;

    protected string $view = 'filament.widgets.sales.payment-method-chart';

    /**
     * Maps the raw value stored in orders.payment_method to a display
     * label + brand color. Add/remove entries here to match whatever
     * gateway keys your app actually stores (check a few rows of the
     * payment_method column if these don't line up).
     */
    protected function paymentMethodMap(): array
    {
        return [
            'cod' => [
                'label' => 'Cash on Delivery (COD)',
                'color' => '#6366f1',
            ],
            'esewa' => [
                'label' => 'eSewa (Demo)',
                'color' => '#22c55e',
            ],
            'khalti' => [
                'label' => 'Khalti (Demo)',
                'color' => '#8b5cf6',
            ],
            'bank_transfer' => [
                'label' => 'Bank Transfer',
                'color' => '#f59e0b',
            ],
        ];
    }

    protected function getRange(): array
    {
        $start = isset($this->filters['startDate'])
            ? Carbon::parse($this->filters['startDate'])->startOfDay()
            : now()->startOfMonth();

        $end = isset($this->filters['endDate'])
            ? Carbon::parse($this->filters['endDate'])->endOfDay()
            : now()->endOfMonth();

        return [$start, $end];
    }

    /**
     * Live breakdown of grand_total grouped by payment_method for the
     * selected date range, mapped to display label/color, with each
     * method's share of the total as a percentage.
     */
    public function getBreakdown(): Collection
    {
        [$start, $end] = $this->getRange();

        $sums = Order::query()
            ->whereBetween('created_at', [$start, $end])
            ->selectRaw('payment_method, SUM(grand_total) as total')
            ->groupBy('payment_method')
            ->pluck('total', 'payment_method');

        $map = $this->paymentMethodMap();
        $grandTotal = $sums->sum();

        return $sums->map(function ($amount, $key) use ($map, $grandTotal) {
            $normalizedKey = strtolower(str_replace([' ', '-'], '_', (string) $key));
            $meta = $map[$normalizedKey] ?? [
                'label' => ucwords(str_replace('_', ' ', (string) $key)),
                'color' => '#94a3b8',
            ];

            return [
                'label' => $meta['label'],
                'color' => $meta['color'],
                'amount' => round((float) $amount, 2),
                'percentage' => $grandTotal > 0 ? round(($amount / $grandTotal) * 100, 1) : 0,
            ];
        })
            ->sortByDesc('amount')
            ->values();
    }

    public function getGrandTotal(): float
    {
        return $this->getBreakdown()->sum('amount');
    }
}
