<?php

namespace App\Filament\Widgets\Customer;

use App\Models\User;
use Carbon\Carbon;
use Filament\Widgets\Concerns\InteractsWithPageFilters;
use Filament\Widgets\Widget;
use Illuminate\Support\Collection;
use Filament\Actions\Action;
use Filament\Actions\ActionGroup;

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

    // Maximum number of top customers to display.
    protected int $customerLimit = 5;

    public function getViewAllUrl(): ?string
    {
        $params = [];


        if (isset($this->dateRange['start'])) {
            $params['tableFilters']['date_range']['start'] = $this->dateRange['start']->toDateString();
        }
        if (isset($this->dateRange['end'])) {
            $params['tableFilters']['date_range']['end'] = $this->dateRange['end']->toDateString();
        }

        try {
            if (\Illuminate\Support\Facades\Route::has('filament.resources.users.index')) {
                return route('filament.resources.users.index', $params);
            }


            if (\Illuminate\Support\Facades\Route::has('filament.admin.resources.users.index')) {
                return route('filament.admin.resources.users.index', $params);
            }


            if (\Illuminate\Support\Facades\Route::has('users.index')) {
                return route('users.index', $params);
            }
        } catch (\Exception $e) {

            return null;
        }

        return null;
    }

    public function getCustomers(): Collection
    {
        $start = $this->dateRange['start'] ?? now()->subDays(90)->startOfDay();
        $end = $this->dateRange['end'] ?? now()->endOfDay();

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
            ->orderByDesc('total_spent')
            ->limit($this->customerLimit)
            ->get()
            ->map(function ($user) {
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

    protected function getHeaderActions(): array
    {
        $viewAllUrl = $this->getViewAllUrl();

        if ($viewAllUrl) {
            return [
                ActionGroup::make([
                    Action::make('viewAll')
                        ->label('View All')
                        ->url($viewAllUrl)
                        ->icon('heroicon-o-arrow-right'),
                ])
                ->label('Actions')
                ->icon('heroicon-o-ellipsis-vertical')
                ->button()
                ->color('gray')
                ->size('sm')
            ];
        }

        return [];
    }

    protected function getListeners(): array
    {
        return [
            'updateCustomerReport' => '$refresh',
        ];
    }
}
