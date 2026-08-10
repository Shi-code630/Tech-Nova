<?php

namespace App\Filament\Widgets\Product;

use App\Filament\Resources\Products\ProductsResource;
use App\Models\OrderItem;
use App\Models\Product;
use Carbon\Carbon;
use Filament\Tables;
use Filament\Tables\Table;
use Filament\Widgets\Concerns\InteractsWithPageFilters;
use Filament\Widgets\TableWidget as BaseWidget;

class TopSellingProducts extends BaseWidget
{
    use InteractsWithPageFilters;

    protected static ?string $heading = 'Top Selling Products';
    protected static ?int $sort = 2;

    protected int|string|array $columnSpan = [
        'default' => 1,
        'md' => 2,
        'xl' => 12,
    ];

    public ?array $filters = [];

    public function table(Table $table): Table
    {
        [$start, $end] = $this->getDateRange();

        return $table
            ->query(
                Product::query()
                    ->select('products.*')
                    ->with('category')
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
                    ->selectSub(
                        \App\Models\Review::query()
                            ->whereColumn('reviews.product_id', 'products.id')
                            ->selectRaw('COALESCE(AVG(rating), 0)'),
                        'avg_rating'
                    )
                    ->having('sold', '>', 0)
                    ->orderByDesc('sold')
                    ->limit(10)
            )
            ->columns([
                Tables\Columns\TextColumn::make('name')
                    ->label('Product')
                    ->weight('semibold')
                    ->url(fn($record) => ProductsResource::getUrl('edit', ['record' => $record->id]))
                    ->limit(30)
                    ->searchable(),

                Tables\Columns\TextColumn::make('category.name')
                    ->label('Category')
                    ->badge()
                    ->color('primary'),

                Tables\Columns\TextColumn::make('sold')
                    ->label('Sold')
                    ->formatStateUsing(fn($state) => $state ?? 0)
                    ->color('primary')
                    ->alignCenter()
                    ->sortable(),

                Tables\Columns\TextColumn::make('revenue')
                    ->label('Revenue')
                    ->formatStateUsing(fn($state) => '$' . number_format($state ?? 0, 2))
                    ->color('success')
                    ->alignEnd()
                    ->sortable(),

                Tables\Columns\TextColumn::make('avg_rating')
                    ->label('Avg. Rating')
                    ->formatStateUsing(fn($state) => number_format($state ?? 0, 1))
                    ->color('warning')
                    ->alignCenter()
                    ->sortable(),
            ])
            ->paginated(false)
            ->defaultSort('sold', 'desc')
            ->emptyStateHeading('No Products Sold')
            ->emptyStateDescription('There are no products sold in the selected period.')
            ->emptyStateIcon('heroicon-o-shopping-bag');
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
            now()->startOfMonth(),
            now()->endOfMonth()
        ];
    }

    protected function getListeners(): array
    {
        return [
            'updateProductReport' => '$refresh',
        ];
    }
}
