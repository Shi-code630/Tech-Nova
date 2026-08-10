<?php

namespace App\Filament\Widgets\Dashboard;

use App\Filament\Pages\SalesReport;
use App\Filament\Resources\Coupons\CouponsResource;
use App\Filament\Resources\DeliveryCharges\DeliveryChargesResource;
use App\Filament\Resources\Orders\OrdersResource;
use App\Filament\Resources\Products\ProductsResource;
use App\Filament\Resources\Users\UserResource;
use Filament\Widgets\Widget;

class QuickActions extends Widget
{
    protected static ?string $heading = 'Quick Actions';
    protected string $view = 'filament.widgets.quick-actions';
    protected static ?int $sort = 6;

    protected int|string|array $columnSpan = [
        'default' => 1,
        'sm' => 2,
        'md' => 2,
        'lg' => 3,
        'xl' => 4,
    ];
     public function getHeading(): string
    {
        return 'Quick Actions';
    }

    protected function getViewData(): array
    {
        return [
            'actions' => [
                [
                    'label' => 'Add Product',
                    'icon' => 'heroicon-o-shopping-cart',
                    'color' => 'primary',
                    'bg_color' => 'bg-blue-50 dark:bg-blue-500/10',
                    'text_color' => 'text-blue-700 dark:text-blue-400',
                    'icon_color' => 'text-blue-600 dark:text-blue-400',
                    'border_color' => 'hover:border-blue-200 dark:hover:border-blue-500/30',
                    'url' => ProductsResource::getUrl('create'),
                ],
                [
                    'label' => 'Create Order',
                    'icon' => 'heroicon-o-shopping-bag',
                    'color' => 'success',
                    'bg_color' => 'bg-green-50 dark:bg-green-500/10',
                    'text_color' => 'text-green-700 dark:text-green-400',
                    'icon_color' => 'text-green-600 dark:text-green-400',
                    'border_color' => 'hover:border-green-200 dark:hover:border-green-500/30',
                    'url' => OrdersResource::getUrl('create'),
                ],
                [
                    'label' => 'Add User',
                    'icon' => 'heroicon-o-user-plus',
                    'color' => 'info',
                    'bg_color' => 'bg-cyan-50 dark:bg-cyan-500/10',
                    'text_color' => 'text-cyan-700 dark:text-cyan-400',
                    'icon_color' => 'text-cyan-600 dark:text-cyan-400',
                    'border_color' => 'hover:border-cyan-200 dark:hover:border-cyan-500/30',
                    'url' => UserResource::getUrl('create'),
                ],
                [
                    'label' => 'Add Coupon',
                    'icon' => 'heroicon-o-ticket',
                    'color' => 'warning',
                    'bg_color' => 'bg-amber-50 dark:bg-amber-500/10',
                    'text_color' => 'text-amber-700 dark:text-amber-400',
                    'icon_color' => 'text-amber-600 dark:text-amber-400',
                    'border_color' => 'hover:border-amber-200 dark:hover:border-amber-500/30',
                    'url' => CouponsResource::getUrl('create'),
                ],
                [
                    'label' => 'Delivery Charge',
                    'icon' => 'heroicon-o-truck',
                    'color' => 'purple',
                    'bg_color' => 'bg-purple-50 dark:bg-purple-500/10',
                    'text_color' => 'text-purple-700 dark:text-purple-400',
                    'icon_color' => 'text-purple-600 dark:text-purple-400',
                    'border_color' => 'hover:border-purple-200 dark:hover:border-purple-500/30',
                    'url' => DeliveryChargesResource::getUrl('create'),
                ],
                [
                    'label' => 'View Reports',
                    'icon' => 'heroicon-o-chart-bar',
                    'color' => 'danger',
                    'bg_color' => 'bg-red-50 dark:bg-red-500/10',
                    'text_color' => 'text-red-700 dark:text-red-400',
                    'icon_color' => 'text-red-600 dark:text-red-400',
                    'border_color' => 'hover:border-red-200 dark:hover:border-red-500/30',
                    'url' => SalesReport::getUrl(),
                ],
            ],
        ];
    }
}
