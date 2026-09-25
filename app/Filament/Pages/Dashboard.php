<?php

namespace App\Filament\Pages;

use Filament\Pages\Dashboard as BaseDashboard;

class Dashboard extends BaseDashboard
{
    public function getColumns(): int|array
    {
        return [
            'default' => 1,
            'md' => 3,
            'xl' => 12,
        ];
    }
    public  function getWidgets(): array
    {
        return [
            \App\Filament\Widgets\Dashboard\SalesOverviewChart::class,
            \App\Filament\Widgets\Dashboard\OrdersByStatusChart::class,
            \App\Filament\Widgets\Dashboard\TopSellingProducts::class,
            \App\Filament\Widgets\Dashboard\RecentOrders::class,
            \App\Filament\Widgets\Dashboard\LowStockAlert::class,
            \App\Filament\Widgets\Dashboard\QuickActions::class,

        ];
    }
     protected function getHeaderWidgets(): array
    {
        return [
            \App\Filament\Widgets\Dashboard\StatsOverview::class,
        ];
    }
     protected function getFooterWidgets(): array
    {
        return [];
    }
}
