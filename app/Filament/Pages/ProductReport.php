<?php

namespace App\Filament\Pages;

use App\Filament\Widgets\Product\LowStockProducts;
use App\Filament\Widgets\Product\ProductStats;
use App\Filament\Widgets\Product\SalesByCategory;
use App\Filament\Widgets\Product\TopSellingProducts;
use App\Models\Order;
use App\Models\Product;
use BackedEnum;
use Carbon\Carbon;
use Filament\Actions\Action;
use Filament\Forms\Components\DatePicker;
use Filament\Pages\Dashboard\Concerns\HasFiltersForm;
use Filament\Pages\Page;
use Filament\Schemas\Schema;
use Filament\Widgets\Concerns\InteractsWithPageFilters;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use Symfony\Component\HttpFoundation\StreamedResponse;

class ProductReport extends Page
{
    use HasFiltersForm;
    use InteractsWithPageFilters;

    protected static string|BackedEnum|null $navigationIcon = 'heroicon-o-chart-bar';

    protected static ?string $title = 'Product Report';
    protected static ?string $navigationLabel = 'Product Report';
    protected static ?string $slug = 'product-report';

    public static function getNavigationGroup(): string
    {
        return 'Reports & Analytics';
    }

    public static function getNavigationSort(): int
    {
        return 3;
    }

    protected string $view = 'filament.pages.product-report';

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
                        $this->dispatch('updateProductReport');
                    }),

                DatePicker::make('endDate')
                    ->label('To')
                    ->native(false)
                    ->default(now()->endOfMonth())
                    ->live()
                    ->afterStateUpdated(function () {
                        $this->dispatch('updateProductReport');
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

        $products = Product::query()
            ->with('category')
            ->withCount(['orderItems as sold' => function ($query) use ($start, $end) {
                $query->whereHas('order', function ($q) use ($start, $end) {
                    $q->whereBetween('created_at', [$start, $end])
                      ->where('order_status', '!=', 'cancelled');
                });
            }])
            ->get();

        $filename = 'product-report-' . $start->format('Y-m-d') . '-to-' . $end->format('Y-m-d') . '.xlsx';

        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();
        $sheet->setTitle('Product Report');

        // Header row
        $headers = ['Product Name', 'Category', 'Price', 'Stock', 'Units Sold', 'Revenue', 'Avg Rating'];
        $sheet->fromArray($headers, null, 'A1');
        $sheet->getStyle('A1:G1')->getFont()->setBold(true);
        $sheet->getStyle('A1:G1')->getFill()
            ->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)
            ->getStartColor()->setRGB('E5E7EB');

        // Data rows
        $row = 2;
        foreach ($products as $product) {
            $revenue = $product->orderItems()
                ->whereHas('order', function ($q) {
                    $q->where('order_status', '!=', 'cancelled');
                })
                ->sum('total');

            $sheet->setCellValue("A{$row}", $product->name);
            $sheet->setCellValue("B{$row}", $product->category->name ?? 'N/A');
            $sheet->setCellValueExplicit("C{$row}", $product->price, \PhpOffice\PhpSpreadsheet\Cell\DataType::TYPE_NUMERIC);
            $sheet->setCellValueExplicit("D{$row}", $product->stock, \PhpOffice\PhpSpreadsheet\Cell\DataType::TYPE_NUMERIC);
            $sheet->setCellValueExplicit("E{$row}", $product->sold ?? 0, \PhpOffice\PhpSpreadsheet\Cell\DataType::TYPE_NUMERIC);
            $sheet->setCellValueExplicit("F{$row}", $revenue ?? 0, \PhpOffice\PhpSpreadsheet\Cell\DataType::TYPE_NUMERIC);
            $sheet->setCellValueExplicit("G{$row}", $product->average_rating ?? 0, \PhpOffice\PhpSpreadsheet\Cell\DataType::TYPE_NUMERIC);

            $row++;
        }

        // Number formatting for money/decimal columns
        $sheet->getStyle("C2:C{$row}")->getNumberFormat()->setFormatCode('#,##0.00');
        $sheet->getStyle("F2:F{$row}")->getNumberFormat()->setFormatCode('#,##0.00');
        $sheet->getStyle("G2:G{$row}")->getNumberFormat()->setFormatCode('0.0');

        // Auto-size columns so content isn't cut off
        foreach (range('A', 'G') as $column) {
            $sheet->getColumnDimension($column)->setAutoSize(true);
        }

        return response()->streamDownload(function () use ($spreadsheet) {
            $writer = new Xlsx($spreadsheet);
            $writer->save('php://output');
        }, $filename, [
            'Content-Type' => 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet',
        ]);
    }

    protected function getHeaderWidgets(): array
    {
        return [

        ];
    }

    protected function getFooterWidgets(): array
    {
        return [];
    }
    protected function getStatsWidgets(): array
{
    return [
        ProductStats::class,
    ];
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
            'updateProductReport' => '$refresh',
        ];
    }
}
