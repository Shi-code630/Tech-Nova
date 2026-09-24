<?php

namespace App\Filament\Pages;

use App\Models\User;
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

class CustomerReport extends Page
{
    use HasFiltersForm;

    protected static string | BackedEnum | null $navigationIcon = 'heroicon-o-users';

    public static function getNavigationGroup(): string
    {
        return 'Reports & Analytics';
    }

    protected static ?string $title = 'Customer Report';

    protected static ?int $navigationSort = 2;

    // This install's Filament version declares $view as non-static
    // (confirmed earlier on Page::$view), so this matches that.
    protected string $view = 'filament.pages.customer-report';

    public function filtersForm(Schema $schema): Schema
    {
        return $schema
            ->components([
                DatePicker::make('startDate')
                    ->label('From')
                    ->native(false)
                    ->default(now()->subDays(90)->startOfDay())
                    ->live(),

                DatePicker::make('endDate')
                    ->label('To')
                    ->native(false)
                    ->default(now()->endOfDay())
                    ->live(),
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
                ->action(fn () => $this->exportReport()),
        ];
    }

    public function exportReport(): StreamedResponse
    {
        $start = Carbon::parse($this->filters['startDate'] ?? now()->subDays(90));
        $end = Carbon::parse($this->filters['endDate'] ?? now());

        $customers = User::query()
            ->whereBetween('created_at', [$start, $end])
            ->withCount(['orders' => fn ($q) => $q->where('order_status', '!=', 'cancelled')->whereBetween('created_at', [$start, $end])])
            ->withSum(['orders' => fn ($q) => $q->where('order_status', '!=', 'cancelled')->whereBetween('created_at', [$start, $end])], 'grand_total')
            ->get();

        $filename = 'customer-report-' . $start->format('Y-m-d') . '-to-' . $end->format('Y-m-d') . '.xlsx';

        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();
        $sheet->setTitle('Customer Report');

        // Header row
        $headers = ['Name', 'Email', 'Joined', 'Orders', 'Total Spent'];
        $sheet->fromArray($headers, null, 'A1');
        $sheet->getStyle('A1:E1')->getFont()->setBold(true);
        $sheet->getStyle('A1:E1')->getFill()
            ->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)
            ->getStartColor()->setRGB('E5E7EB');

        // Data rows
        $row = 2;
        foreach ($customers as $customer) {
            $sheet->setCellValue("A{$row}", $customer->name);
            $sheet->setCellValue("B{$row}", $customer->email);
            $sheet->setCellValue("C{$row}", $customer->created_at->format('Y-m-d'));
            $sheet->setCellValue("D{$row}", $customer->orders_count);
            $sheet->setCellValueExplicit(
                "E{$row}",
                $customer->orders_sum_grand_total ?? 0,
                \PhpOffice\PhpSpreadsheet\Cell\DataType::TYPE_NUMERIC
            );
            $row++;
        }

        // Auto-size columns so content isn't cut off
        foreach (range('A', 'E') as $column) {
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
    protected function getListeners(): array
    {
        return [
            'updateCustomerReport' => '$refresh',
        ];
    }
}
