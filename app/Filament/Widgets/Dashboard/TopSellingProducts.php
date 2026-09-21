<?php

namespace App\Filament\Widgets\Dashboard;

use App\Filament\Resources\Products\ProductsResource;
use App\Models\Product;
use Filament\Actions\Action;
use Filament\Tables;
use Filament\Tables\Table;
use Filament\Widgets\TableWidget as BaseWidget;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\DB;

class TopSellingProducts extends BaseWidget
{
    protected static ?int $sort = 5;

    protected int|string|array $columnSpan = [
        'default' => 1,
        'md' => 2,
        'xl' => 5,
    ];

    protected static ?string $heading = 'Top Selling Products';

    public function table(Table $table): Table
    {
        return $table
            ->query(
                function (): Builder {
                    return Product::query()
                        ->select('products.*')
                        ->selectSub(
                            DB::table('order_items')
                                ->whereColumn('order_items.product_id', 'products.id')
                                ->selectRaw('COALESCE(SUM(order_items.quantity), 0)'),
                            'sold'
                        )
                        ->selectSub(
                            DB::table('order_items')
                                ->whereColumn('order_items.product_id', 'products.id')
                                ->selectRaw('COALESCE(SUM(order_items.total), 0)'),
                            'revenue'
                        )
                        ->orderByDesc('sold')
                        ->limit(5);
                }
            )
            ->columns([
                Tables\Columns\ImageColumn::make('thumbnails')
                    ->label('')
                    ->circular()
                    ->size(36)
                    ->getStateUsing(function ($record) {
                        if (is_array($record->thumbnails) && !empty($record->thumbnails)) {
                            $firstThumbnail = $record->thumbnails[0];
                            if (!str_starts_with($firstThumbnail, 'http')) {
                                return asset('storage/' . $firstThumbnail);
                            }
                            return $firstThumbnail;
                        }

                        return 'https://ui-avatars.com/api/?name=' . urlencode($record->name) . '&background=6366f1&color=fff&size=36';
                    }),

                Tables\Columns\TextColumn::make('name')
                    ->label('Product')
                    ->weight('semibold')
                    ->limit(30)
                    ->tooltip(fn($record) => $record->name),

                Tables\Columns\TextColumn::make('sold')
                    ->label('Sold')
                    ->formatStateUsing(fn($state) => number_format($state ?? 0))
                    ->alignCenter()
                    ->badge()
                    ->color(fn($state) => $state > 0 ? 'success' : 'gray'),

                Tables\Columns\TextColumn::make('revenue')
                    ->label('Revenue')
                    ->formatStateUsing(fn($state) => 'Rs. ' . number_format($state ?? 0, 2))
                    ->alignRight()
                    ->color(fn($state) => $state > 0 ? 'success' : 'gray'),
            ])
            ->paginated(false)
            ->defaultSort('sold', 'desc')
            ->headerActions([
                Action::make('viewAll')
                    ->label('View All Products')
                    ->url(ProductsResource::getUrl('index'))
                    ->outlined()
                    ->icon('heroicon-o-arrow-right'),
            ])
            ->emptyStateHeading('No Products Found')
            ->emptyStateDescription('Please add products to see them here.')
            ->emptyStateIcon('heroicon-o-shopping-bag');
    }
}
