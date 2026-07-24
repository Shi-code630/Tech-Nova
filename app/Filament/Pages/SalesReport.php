<?php

namespace App\Filament\Pages;

use App\Models\Order;
use Carbon\Carbon;
use BackedEnum;
use Filament\Forms\Components\DatePicker;
use Filament\Pages\Page;
use Filament\Schemas\Components\Form;


class SalesReport extends Page
{
   protected static string|BackedEnum|null $navigationIcon = 'heroicon-o-chart-bar';

   // protected static string $view = 'filament.pages.sales-report';

     public static function getNavigationGroup(): ?string
    {
        return 'Reports';
    }

    public static function getNavigationSort(): ?int
    {
        return 21;
    }

    protected static ?int $navigationSort = 1;

    protected static ?string $navigationLabel = 'Sales Report';

    protected static ?string $title = 'Sales Report';

    protected static ?string $slug = 'sales-report';

    public ?array $data = [];

    public $startDate;
    public $endDate;

    public function mount(): void
    {
        $this->startDate = Carbon::now()->startOfMonth()->format('Y-m-d');
        $this->endDate = Carbon::now()->format('Y-m-d');
        $this->data['startDate'] = $this->startDate;
        $this->data['endDate'] = $this->endDate;
    }

    public function form(Form $form): Form
    {
        return $form
            ->schema([
                DatePicker::make('startDate')
                    ->label('Start Date')
                    ->default(Carbon::now()->startOfMonth()),
                DatePicker::make('endDate')
                    ->label('End Date')
                    ->default(Carbon::now()),
            ])
            ->statePath('data');
    }

    public function applyFilters(): void
    {
        $this->startDate = $this->data['startDate'] ?? Carbon::now()->startOfMonth()->format('Y-m-d');
        $this->endDate = $this->data['endDate'] ?? Carbon::now()->format('Y-m-d');
    }

    public function getViewData(): array
    {
        $start = Carbon::parse($this->startDate)->startOfDay();
        $end = Carbon::parse($this->endDate)->endOfDay();

        $orders = Order::whereBetween('created_at', [$start, $end])
            ->where('status', 'completed')
            ->get();

        $totalSales = $orders->sum('total');
        $totalOrders = $orders->count();
        $averageOrder = $totalOrders > 0 ? $totalSales / $totalOrders : 0;

        // Daily sales data for chart
        $dailySales = Order::whereBetween('created_at', [$start, $end])
            ->where('status', 'completed')
            ->selectRaw('DATE(created_at) as date, SUM(total) as total, COUNT(*) as count')
            ->groupBy('date')
            ->orderBy('date')
            ->get();

        return [
            'totalSales' => $totalSales,
            'totalOrders' => $totalOrders,
            'averageOrder' => $averageOrder,
            'orders' => $orders->take(10),
            'dailySales' => $dailySales,
            'startDate' => $this->startDate,
            'endDate' => $this->endDate,
        ];
    }
}
