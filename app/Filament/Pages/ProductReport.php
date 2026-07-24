<?php

namespace App\Filament\Pages;

use App\Models\Product;
use App\Models\OrderItem;
use Carbon\Carbon;
use BackedEnum;
use Filament\Pages\Page;


class ProductReport extends Page
{
  protected static string|BackedEnum|null $navigationIcon = 'heroicon-o-chart-bar';

    //protected static string $view = 'filament.pages.product-report';

   public static function getNavigationGroup(): ?string
    {
        return 'Reports';
    }
    public static function getNavigationSort(): ?int
    {
        return 22;
    }

    protected static ?string $navigationLabel = 'Product Report';

    protected static ?string $title = 'Product Report';

    protected static ?string $slug = 'product-report';

    public $startDate;
    public $endDate;

    public function mount()
    {
        $this->startDate = Carbon::now()->startOfMonth()->format('Y-m-d');
        $this->endDate = Carbon::now()->format('Y-m-d');
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

        return [
            'topProducts' => $topProducts,
            'totalProducts' => $totalProducts,
            'activeProducts' => $activeProducts,
            'outOfStockProducts' => $outOfStockProducts,
        ];
    }
}
