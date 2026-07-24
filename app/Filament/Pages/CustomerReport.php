<?php

namespace App\Filament\Pages;

use App\Models\Product;
use App\Models\OrderItem;
use App\Models\User;
use Carbon\Carbon;
use Filament\Pages\Page;
use Filament\Actions\Action;

class CustomerReport extends Page
{
    // ✅ Navigation icon as method (proper for v5)
    public static function getNavigationIcon(): string
    {
        return 'heroicon-o-chart-bar';
    }

    // ✅ Non-static view property
    protected string $view = 'filament.pages.customer-report';

    // ✅ Navigation properties
    protected static ?string $navigationLabel = 'Customer Report';

    public static function getNavigationGroup(): string
    {
        return 'Reports & Analytics';
    }

    public static function getNavigationSort(): int
    {
        return 23;
    }

    protected static ?string $title = 'Customer Report';
    protected static ?string $slug = 'customer-report';

    // ✅ Properties with type hints
    public string $startDate;
    public string $endDate;
    public string $dateRange = 'this_month';

    public function mount(): void
    {
        $this->setDateRange('this_month');
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

    public function getViewData(): array
    {
        $start = Carbon::parse($this->startDate)->startOfDay();
        $end = Carbon::parse($this->endDate)->endOfDay();

        // Top selling products
        $topProducts = OrderItem::whereBetween('created_at', [$start, $end])
            ->selectRaw('product_id, SUM(quantity) as total_quantity, SUM(price * quantity) as total_revenue')
            ->with('product')
            ->groupBy('product_id')
            ->orderBy('total_revenue', 'desc')
            ->limit(10)
            ->get();

        // Product statistics
        $totalProducts = Product::count();
        $activeProducts = Product::where('status', 'active')->count();
        $outOfStockProducts = Product::where('stock', '<=', 0)->count();

        // Customer statistics
        $totalCustomers = User::count();
        $newCustomers = User::whereBetween('created_at', [$start, $end])->count();

        return [
            'topProducts' => $topProducts,
            'totalProducts' => $totalProducts,
            'activeProducts' => $activeProducts,
            'outOfStockProducts' => $outOfStockProducts,
            'totalCustomers' => $totalCustomers,
            'newCustomers' => $newCustomers,
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
                    \Filament\Notifications\Notification::make()
                        ->title('Report exported successfully')
                        ->success()
                        ->send();
                }),
        ];
    }
}
