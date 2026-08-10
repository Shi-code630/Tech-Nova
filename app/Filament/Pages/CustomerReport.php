<?php

namespace App\Filament\Pages;

use App\Filament\Widgets\Customer\CustomerGrowthChart;
use App\Filament\Widgets\Customer\CustomerStats;
use App\Filament\Widgets\Customer\CustomersByLocation;
use App\Filament\Widgets\Customer\TopCustomers;
use App\Models\User;
use BackedEnum;
use Carbon\Carbon;
use Filament\Actions\Action;
use Filament\Forms\Components\DatePicker;
use Filament\Pages\Dashboard\Concerns\HasFiltersForm;
use Filament\Pages\Page;
use Filament\Schemas\Schema;
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

        $filename = 'customer-report-' . $start->format('Y-m-d') . '-to-' . $end->format('Y-m-d') . '.csv';

        return response()->streamDownload(function () use ($customers) {
            $handle = fopen('php://output', 'w');
            fputcsv($handle, ['Name', 'Email', 'Joined', 'Orders', 'Total Spent']);

            foreach ($customers as $customer) {
                fputcsv($handle, [
                    $customer->name,
                    $customer->email,
                    $customer->created_at->format('Y-m-d'),
                    $customer->orders_count,
                    $customer->orders_sum_grand_total ?? 0,
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
}
