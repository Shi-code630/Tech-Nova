<?php

namespace App\Filament\Widgets\Sales;

use App\Models\OrderItem;
use App\Models\Product;
use Carbon\Carbon;
use Filament\Actions\Action;
use Filament\Tables;
use Filament\Tables\Table;
use Filament\Widgets\Concerns\InteractsWithPageFilters;
use Filament\Widgets\TableWidget as BaseWidget;

class TopSellingProducts extends BaseWidget
{
    use InteractsWithPageFilters;

    protected static ?string $heading = 'Top Selling Products';
    protected static ?int $sort = 5;

    protected int|string|array $columnSpan = [
        'default' => 1,
        'md' => 2,
        'xl' => 6,
    ];

    public ?array $filters = [];

    public function table(Table $table): Table
    {
        [$start, $end] = $this->getDateRange();

        return $table
            ->query(
                Product::query()
                    ->select('products.*')
                    ->with('images')
                    ->selectSub(
                        OrderItem::query()
                            ->join('orders', 'orders.id', '=', 'order_items.order_id')
                            ->whereColumn('order_items.product_id', 'products.id')
                            ->whereBetween('orders.created_at', [$start, $end])
                            ->where('orders.order_status', '!=', 'cancelled')
                            ->selectRaw('COALESCE(SUM(order_items.quantity), 0)'),
                        'sold'
                    )
                    ->selectSub(
                        OrderItem::query()
                            ->join('orders', 'orders.id', '=', 'order_items.order_id')
                            ->whereColumn('order_items.product_id', 'products.id')
                            ->whereBetween('orders.created_at', [$start, $end])
                            ->where('orders.order_status', '!=', 'cancelled')
                            ->selectRaw('COALESCE(SUM(order_items.quantity * order_items.price), 0)'),
                        'revenue'
                    )
                    ->having('sold', '>', 0)
                    ->orderByDesc('sold')
                    ->limit(5)
            )
            ->columns([
                Tables\Columns\TextColumn::make('name')
                    ->label('Product')
                    ->weight('semibold')
                    ->size('sm')
                    ->searchable()
                    ->formatStateUsing(function ($record) {
                        $initials = $this->getInitials($record->name);
                        $color = $this->getColor($record->id);
                        $image = $record->images->first()?->image;

                        if ($image) {
                            $imageHtml = '<img src="' . asset('storage/' . $image) . '" class="w-10 h-10 rounded-lg object-cover">';
                        } else {
                            $imageHtml = '<div class="w-10 h-10 rounded-lg bg-gradient-to-br ' . $color . ' flex items-center justify-center text-white font-semibold text-xs shadow-sm">' . $initials . '</div>';
                        }

                        return '<div class="flex items-center gap-3">
                            ' . $imageHtml . '
                            <span class="font-medium text-gray-900 dark:text-white">' . $record->name . '</span>
                        </div>';
                    })
                    ->html(),

                Tables\Columns\TextColumn::make('sold')
                    ->label('Sold')
                    ->formatStateUsing(fn($state) => $state ?? 0)
                    ->alignCenter()
                    ->sortable()
                    ->formatStateUsing(fn($state) => '<span class="inline-flex items-center justify-center px-3 py-0.5 rounded-full text-sm font-medium bg-indigo-50 text-indigo-700 dark:bg-indigo-900/30 dark:text-indigo-400">' . $state . '</span>')
                    ->html(),

                Tables\Columns\TextColumn::make('revenue')
                    ->label('Revenue')
                    ->formatStateUsing(fn($state) => '$' . number_format($state ?? 0, 2))
                    ->alignEnd()
                    ->sortable()
                    ->weight('semibold')
                    ->size('sm')
                    ->color('gray-900 dark:white'),
            ])
            ->paginated(false)
            ->defaultSort('sold', 'desc')
            ->emptyStateHeading('No Products Sold')
            ->emptyStateDescription('There are no products sold in this period.')
            ->emptyStateIcon('heroicon-o-shopping-bag')
            ->headerActions([
                Action::make('viewAll')
                    ->label('View All')
                    ->url(route('filament.admin.resources.products.index'))
                    ->outlined()
                    ->icon('heroicon-m-arrow-up-right')
                    ->size('sm')
                    ->color('gray'),
            ]);
    }

    protected function getInitials(string $name): string
    {
        $words = explode(' ', $name);
        $initials = '';
        foreach ($words as $word) {
            if (!empty($word)) {
                $initials .= strtoupper($word[0]);
            }
        }
        return substr($initials, 0, 2);
    }

    protected function getColor(int $id): string
    {
        $colors = [
            'from-indigo-500 to-indigo-600',
            'from-blue-500 to-blue-600',
            'from-green-500 to-green-600',
            'from-purple-500 to-purple-600',
            'from-pink-500 to-pink-600',
            'from-yellow-500 to-yellow-600',
            'from-red-500 to-red-600',
            'from-teal-500 to-teal-600',
        ];
        return $colors[$id % count($colors)];
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

        return [
            now()->subDays(90)->startOfDay(),
            now()->endOfDay()
        ];
    }

    protected function getListeners(): array
    {
        return [
            'updateDashboard' => '$refresh',
        ];
    }
}
