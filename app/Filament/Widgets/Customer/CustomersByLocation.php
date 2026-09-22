<?php

namespace App\Filament\Widgets\Customer;

use App\Models\User;
use Carbon\Carbon;
use Filament\Widgets\Concerns\InteractsWithPageFilters;
use Filament\Widgets\Widget;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;

class CustomersByLocation extends Widget
{
    use InteractsWithPageFilters;

    protected static ?string $heading = 'Customers by Location';
    protected static ?int $sort = 2;

    protected int|string|array $columnSpan = [
        'default' => 1,
        'md' => 2,
        'xl' => 6,
    ];

    protected string $view = 'filament.widgets.customer.customers-by-location';

    public ?array $filters = [];


    protected int $locationLimit = 5;

    public function getLocationData(): Collection
    {
        [$start, $end] = $this->getDateRange();

        $data = User::query()
            ->join('addresses', function ($join) {
                $join->on('addresses.user_id', '=', 'users.id')
                    ->where('addresses.is_default', true);
            })
            ->select('addresses.city', DB::raw('COUNT(DISTINCT users.id) as total'))
            ->whereNotNull('addresses.city')
            ->where('addresses.city', '!=', '')
            ->when($start && $end, function ($query) use ($start, $end) {
                $query->whereBetween('users.created_at', [$start, $end]);
            })
            ->groupBy('addresses.city')
            ->orderByDesc('total')
            ->get();

        // True total across ALL cities (not just the ones displayed),
        // so percentages stay accurate.
        $total = $data->sum('total');

        $colors = [
            'from-indigo-500 to-indigo-600',
            'from-blue-500 to-blue-600',
            'from-green-500 to-green-600',
            'from-purple-500 to-purple-600',
            'from-pink-500 to-pink-600',
            'from-yellow-500 to-yellow-600',
            'from-red-500 to-red-600',
            'from-teal-500 to-teal-600',
            'from-orange-500 to-orange-600',
            'from-cyan-500 to-cyan-600',
        ];

        // ---- Limit to top N cities, group the rest into "Others" ----
        $limited = $data->take($this->locationLimit);
        $remaining = $data->slice($this->locationLimit);

        if ($remaining->isNotEmpty()) {
            $othersRow = (object) [
                'city' => 'Others',
                'total' => $remaining->sum('total'),
            ];

            $displayData = $limited->push($othersRow);
        } else {
            $displayData = $limited;
        }
        // ---------------------------------------------------------

        return $displayData->values()->map(function ($item, $index) use ($total, $colors) {
            $percentage = $total > 0 ? round(($item->total / $total) * 100, 1) : 0;
            $isOthers = $item->city === 'Others';

            return (object) [
                'location' => $isOthers ? 'Others' : ucfirst($item->city),
                'total' => $item->total,
                'percentage' => $percentage,
                'color' => $isOthers ? 'from-gray-400 to-gray-500' : $colors[$index % count($colors)],
            ];
        });
    }

    protected function getDateRange(): array
    {
        $startDate = $this->filters['startDate'] ?? null;
        $endDate = $this->filters['endDate'] ?? null;

        if ($startDate && $endDate) {
            return [
                Carbon::parse($startDate)->startOfDay(),
                Carbon::parse($endDate)->endOfDay()
            ];
        }

        return [null, null];
    }

    protected function getListeners(): array
    {
        return [
            'updateCustomerReport' => '$refresh',
        ];
    }
}
