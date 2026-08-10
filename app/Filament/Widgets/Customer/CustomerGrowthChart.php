<?php

namespace App\Filament\Widgets\Customer;

use App\Models\User;
use Carbon\Carbon;
use Carbon\CarbonPeriod;
use Filament\Widgets\ChartWidget;
use Filament\Widgets\Concerns\InteractsWithPageFilters;

class CustomerGrowthChart extends ChartWidget
{
    use InteractsWithPageFilters;

    protected static ?int $sort = 2;

    protected ?string $heading = 'Customer Growth';

    protected ?string $maxHeight = '320px';

    public ?string $filter = 'daily';

    protected function getFilters(): ?array
    {
        return [
            'daily' => 'Daily',
            'weekly' => 'Weekly',
            'monthly' => 'Monthly',  // Fixed typo: monthlay -> monthly
            'yearly' => 'Yearly'
        ];
    }

    protected function getData(): array
    {
        $start = isset($this->filters['startDate'])
            ? Carbon::parse($this->filters['startDate'])->startOfDay()
            : now()->subDays(90)->startOfDay();

        $end = isset($this->filters['endDate'])
            ? Carbon::parse($this->filters['endDate'])->endOfDay()
            : now()->endOfDay();

        // Adjust interval based on filter
        $interval = match($this->filter) {
            'weekly' => '1 week',
            'monthly' => '1 month',
            'yearly' => '1 year',
            default => '1 day',
        };

        $period = CarbonPeriod::create($start, $interval, $end);

        $baseline = User::query()->where('created_at', '<', $start)->count();

        $signupsByBucket = User::query()
            ->whereBetween('created_at', [$start, $end])
            ->get()
            ->groupBy(function ($user) {
                return match($this->filter) {
                    'weekly' => $user->created_at->startOfWeek()->format('Y-m-d'),
                    'monthly' => $user->created_at->format('Y-m'),
                    'yearly' => $user->created_at->format('Y'),
                    default => $user->created_at->format('Y-m-d'),
                };
            });

        $labels = [];
        $cumulative = [];
        $running = $baseline;

        foreach ($period as $date) {
            $key = match($this->filter) {
                'weekly' => $date->startOfWeek()->format('Y-m-d'),
                'monthly' => $date->format('Y-m'),
                'yearly' => $date->format('Y'),
                default => $date->format('Y-m-d'),
            };

            $running += $signupsByBucket->get($key)?->count() ?? 0;

            // Format labels based on filter
            $labels[] = match($this->filter) {
                'weekly' => 'Week ' . $date->weekOfYear . ' ' . $date->format('M'),
                'monthly' => $date->format('M Y'),
                'yearly' => $date->format('Y'),
                default => $date->format('M d'),
            };
            $cumulative[] = $running;
        }

        return [
            'datasets' => [
                [
                    'label' => 'Total Customers',
                    'data' => $cumulative,
                    'borderColor' => '#6366f1',
                    'backgroundColor' => 'rgba(99, 102, 241, 0.15)',
                    'fill' => true,
                    'tension' => 0.4,
                    'pointRadius' => 0,
                    'borderWidth' => 2,
                ],
            ],
            'labels' => $labels,
        ];
    }

    protected function getType(): string
    {
        return 'line';
    }

    protected function getOptions(): array
    {
        return [
            'plugins' => [
                'legend' => ['display' => false],
            ],
        ];
    }
}
