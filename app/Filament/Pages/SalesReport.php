<?php

namespace App\Filament\Pages;

use App\Models\Product;
use App\Models\Order;
use BackedEnum;
use Carbon\Carbon;
use Filament\Actions\Action;
use Filament\Forms\Components\DatePicker;
use Filament\Pages\Dashboard\Concerns\HasFiltersForm;
use Filament\Pages\Page;
use Filament\Schemas\Schema;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
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

        $filename = 'sales-report-' . $start->format('Y-m-d') . '-to-' . $end->format('Y-m-d') . '.xlsx';

        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();
        $sheet->setTitle('Sales Report');

        // Header row
        $headers = ['Order Number', 'Date', 'Customer', 'Payment Method', 'Payment Status', 'Order Status', 'Grand Total'];
        $sheet->fromArray($headers, null, 'A1');
        $sheet->getStyle('A1:G1')->getFont()->setBold(true);
        $sheet->getStyle('A1:G1')->getFill()
            ->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)
            ->getStartColor()->setRGB('E5E7EB');

        // Data rows
        $row = 2;
        foreach ($orders as $order) {
            $sheet->setCellValue("A{$row}", $order->order_number);
            $sheet->setCellValue("B{$row}", $order->created_at->format('Y-m-d H:i'));
            $sheet->setCellValue("C{$row}", optional($order->user)->name);
            $sheet->setCellValue("D{$row}", $order->payment_method);
            $sheet->setCellValue("E{$row}", $order->payment_status);
            $sheet->setCellValue("F{$row}", $order->order_status);
            $sheet->setCellValueExplicit("G{$row}", $order->grand_total, \PhpOffice\PhpSpreadsheet\Cell\DataType::TYPE_NUMERIC);

            $row++;
        }

        // Money formatting for Grand Total
        $sheet->getStyle("G2:G{$row}")->getNumberFormat()->setFormatCode('#,##0.00');

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
