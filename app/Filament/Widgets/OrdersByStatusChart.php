<?php

namespace App\Filament\Widgets;

use App\Models\Order;
use Filament\Widgets\ChartWidget;

class OrdersByStatusChart extends ChartWidget
{
    protected ?string $heading = 'Orders by Status';
    protected static ?int $sort = 2;
    protected int|string|array $columnSpan = 4;

    protected function getData(): array
    {
        // Use the scopes from your Order model
        $delivered = Order::delivered()->count();
        $processing = Order::processing()->count();
        $pending = Order::pending()->count();
        $cancelled = Order::cancelled()->count();

        // Also get shipped orders if needed
        $shipped = Order::where('order_status', 'shipped')->count();

        // Combine processing and shipped if you want
        $processing = $processing + $shipped;

        $total = $delivered + $processing + $pending + $cancelled;

        // If no data exists, use sample data
        if ($total == 0) {
            $delivered = 562;
            $processing = 312;
            $pending = 250;
            $cancelled = 124;
            $total = 1248;
        }

        $data = [$delivered, $processing, $pending, $cancelled];
        $labels = [
            "Delivered: " . round(($delivered/$total)*100) . "% ($delivered)",
            "Processing: " . round(($processing/$total)*100) . "% ($processing)",
            "Pending: " . round(($pending/$total)*100) . "% ($pending)",
            "Cancelled: " . round(($cancelled/$total)*100) . "% ($cancelled)"
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
            'cutout' => '65%',
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
        return 'This Month';
    }
}
