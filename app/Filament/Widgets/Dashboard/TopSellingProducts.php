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
                        ->leftJoin('order_items', 'products.id', '=', 'order_items.product_id')
                        ->select(
                            'products.*',
                            DB::raw('COALESCE(SUM(order_items.quantity), 0) as sold'),
                            DB::raw('COALESCE(SUM(order_items.total), 0) as revenue')
                        )
                        ->groupBy(
                            'products.id',
                            'products.name',
                            'products.thumbnails',
                            'products.category_id',
                            'products.brand_id',
                            'products.slug',
                            'products.description',
                            'products.price',
                            'products.discount_price',
                            'products.stock',
                            'products.status',
                            'products.featured',
                            'products.meta_title',
                            'products.meta_description',
                            'products.meta_keywords',
                            'products.created_at',
                            'products.updated_at'
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
                        // Get the first thumbnail from the array
                        if (is_array($record->thumbnails) && !empty($record->thumbnails)) {
                            $firstThumbnail = $record->thumbnails[0];
                            // If it's a storage path, add 'storage/' prefix
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
                    ->tooltip(fn ($record) => $record->name),

                Tables\Columns\TextColumn::make('sold')
                    ->label('Sold')
                    ->formatStateUsing(fn ($state) => number_format($state ?? 0))
                    ->alignCenter()
                    ->badge()
                    ->color(fn ($state) => $state > 0 ? 'success' : 'gray'),

                Tables\Columns\TextColumn::make('revenue')
                    ->label('Revenue')
                    ->formatStateUsing(fn ($state) => 'Rs. ' . number_format($state ?? 0, 2))
                    ->alignRight()
                    ->color(fn ($state) => $state > 0 ? 'success' : 'gray'),
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
