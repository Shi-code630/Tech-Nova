<?php

namespace App\Filament\Widgets\Product;

use App\Filament\Resources\Products\ProductsResource;
use App\Models\OrderItem;
use App\Models\Product;
use Filament\Actions\Action;
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



    public function table(Table $table): Table
    {

        $start = $this->dateRange['start'] ?? now()->startOfMonth();
        $end = $this->dateRange['end'] ?? now()->endOfMonth();

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

                    ->orderByDesc('sold')
                    ->limit(5)
            )
            ->columns([
                Tables\Columns\TextColumn::make('name')
                    ->label('Product')
                    ->weight('semibold')
                    ->url(fn($record) => ProductsResource::getUrl('edit', ['record' => $record->id]))
                    ->limit(5),


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

            ->headerActions([
                Action::make('view_all')
                    ->label('View All')
                    ->color('gray')
                    ->outlined()
                    ->url(function () {

                        $params = [];
                        if (isset($this->dateRange['start'])) {
                            $params['tableFilters']['date_range']['start'] = $this->dateRange['start']->toDateString();
                        }
                        if (isset($this->dateRange['end'])) {
                            $params['tableFilters']['date_range']['end'] = $this->dateRange['end']->toDateString();
                        }

                        return ProductsResource::getUrl('index', $params);
                    })
            ])

            ->paginated(false)
            ->defaultSort('sold', 'desc')
            ->emptyStateHeading('No Products Sold')
            ->emptyStateDescription('There are no products sold in the selected period.')
            ->emptyStateIcon('heroicon-o-shopping-bag');
    }


    protected function getListeners(): array
    {
        return [
            'updateProductReport' => '$refresh',
        ];
    }
}
