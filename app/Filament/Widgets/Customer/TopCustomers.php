<?php

namespace App\Filament\Widgets\Customer;

use App\Models\User;
use Carbon\Carbon;
use Filament\Widgets\Concerns\InteractsWithPageFilters;
use Filament\Widgets\Widget;
use Illuminate\Support\Collection;

class TopCustomers extends Widget
{
    use InteractsWithPageFilters;

    protected static ?string $heading = 'Top Customers';
    protected static ?int $sort = 4;

    protected int|string|array $columnSpan = [
        'default' => 1,
        'md' => 2,
        'xl' => 6,
    ];

    protected string $view = 'filament.widgets.customer.top-customers';

    public ?array $filters = [];

    protected function getRange(): array
    {
        $startDate = $this->filters['startDate'] ?? null;
        $endDate = $this->filters['endDate'] ?? null;

        if ($startDate && $endDate) {
            return [
                Carbon::parse($startDate)->startOfDay(),
                Carbon::parse($endDate)->endOfDay()
            ];
        }

        return [
            now()->subDays(90)->startOfDay(),
            now()->endOfDay()
        ];
    }

    public function getCustomers(): Collection
    {
        [$start, $end] = $this->getRange();

        return User::query()
            ->select('users.*')
            ->withCount(['orders as orders_count' => function ($query) use ($start, $end) {
                $query->whereBetween('created_at', [$start, $end])
                      ->where('order_status', '!=', 'cancelled');
            }])
            ->withSum(['orders as total_spent' => function ($query) use ($start, $end) {
                $query->whereBetween('created_at', [$start, $end])
                      ->where('order_status', '!=', 'cancelled');
            }], 'grand_total')
            ->having('orders_count', '>', 0)
            ->orderByDesc('total_spent') // ✅ Sort by total spent (matches design)
            ->limit(5)
            ->get()
            ->map(function ($user) {
                // Get initials
                $name = $user->name ?? 'Guest';
                $words = explode(' ', $name);
                $initials = '';
                foreach ($words as $word) {
                    if (!empty($word)) {
                        $initials .= strtoupper($word[0]);
                    }
                }
                $initials = substr($initials, 0, 2);

                return (object) [
                    'id' => $user->id,
                    'name' => $name,
                    'email' => $user->email,
                    'initials' => $initials,
                    'orders_count' => $user->orders_count ?? 0,
                    'total_spent' => $user->total_spent ?? 0,
                ];
            });
    }

    protected function getListeners(): array
    {
        return [
            'updateCustomerReport' => '$refresh',
        ];
    }
}
