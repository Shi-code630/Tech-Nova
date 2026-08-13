<?php

namespace App\Filament\Pages;

use App\Filament\Widgets\Sales\PaymentMethodChart;
use App\Filament\Widgets\Sales\SalesByCategory;
use App\Filament\Widgets\Sales\SalesOverviewChart;
use App\Filament\Widgets\Sales\SalesStats;
use App\Filament\Widgets\Sales\TopSellingProducts;
use App\Models\Order;
use BackedEnum;
use Carbon\Carbon;
use Filament\Actions\Action;
use Filament\Forms\Components\DatePicker;
use Filament\Pages\Dashboard\Concerns\HasFiltersForm;
use Filament\Pages\Page;
use Filament\Schemas\Schema;
use Symfony\Component\HttpFoundation\StreamedResponse;

class SalesReport extends Page
{
    use HasFiltersForm;

    protected static string|BackedEnum|null $navigationIcon = 'heroicon-o-presentation-chart-line';

    public static function getNavigationGroup(): string
    {
        return 'Reports & Analytics';
    }
      public function getColumns(): int|array
    {
        return [
            'default' => 1,
            'md' => 3,
            'xl' => 12,
        ];
    }
    protected static ?string $title = 'Sales Report';

    protected static ?int $navigationSort = 1;

    protected string $view = 'filament.pages.sales-report';

    public function filtersForm(Schema $schema): Schema
    {
        return $schema
            ->components([
                DatePicker::make('startDate')
                    ->label('From')
                    ->native(false)
                    ->default(now()->startOfMonth())
                    ->live()
                    ->afterStateUpdated(function () {
                        $this->dispatch('updateSalesReport');
                    }),

                DatePicker::make('endDate')
                    ->label('To')
                    ->native(false)
                    ->default(now()->endOfMonth())
                    ->live()
                    ->afterStateUpdated(function () {
                        $this->dispatch('updateSalesReport');
                    }),
            ])
            ->columns(2);
    }

    protected function getHeaderActions(): array
    {
        return [
            Action::make('export')
                ->label('Export Report')
                ->icon('heroicon-o-arrow-down-tray')
                ->color('primary')
                ->action(fn() => $this->exportReport()),
        ];
    }

    public function exportReport(): StreamedResponse
    {
        $start = Carbon::parse($this->filters['startDate'] ?? now()->startOfMonth());
        $end = Carbon::parse($this->filters['endDate'] ?? now()->endOfMonth());

        $orders = Order::query()
            ->with('user')
            ->whereBetween('created_at', [$start, $end])
            ->get();

        $filename = 'sales-report-' . $start->format('Y-m-d') . '-to-' . $end->format('Y-m-d') . '.csv';

        return response()->streamDownload(function () use ($orders) {
            $handle = fopen('php://output', 'w');
            fputcsv($handle, ['Order Number', 'Date', 'Customer', 'Payment Method', 'Payment Status', 'Order Status', 'Grand Total']);

            foreach ($orders as $order) {
                fputcsv($handle, [
                    $order->order_number,
                    $order->created_at->format('Y-m-d H:i'),
                    optional($order->user)->name,
                    $order->payment_method,
                    $order->payment_status,
                    $order->order_status,
                    $order->grand_total,
                ]);
            }

            fclose($handle);
        }, $filename);
    }

  protected function getHeaderWidgets(): array
    {
        return [];
    }

    protected function getFooterWidgets(): array
    {
        return [];
    }

    protected function getViewData(): array
    {
        return [
            'filters' => $this->filters ?? [],
        ];
    }

    protected function getListeners(): array
    {
        return [
            'updateSalesReport' => '$refresh',
        ];
    }
}
