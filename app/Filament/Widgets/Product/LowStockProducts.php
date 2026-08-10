<?php

namespace App\Filament\Widgets\Product;

use App\Filament\Resources\Products\ProductsResource;
use App\Models\Product;
use Filament\Actions\Action;
use Filament\Tables;
use Filament\Tables\Table;
use Filament\Widgets\TableWidget as BaseWidget;

class LowStockProducts extends BaseWidget
{
    protected static ?string $heading = 'Low Stock Products';
    protected static ?int $sort = 4;

    protected int|string|array $columnSpan = [
        'default' => 1,
        'md' => 2,
        'xl' => 12,
    ];

    public function table(Table $table): Table
    {
        return $table
            ->query(
                Product::query()
                    ->where('stock', '<=', 10)
                    ->with('category')
                    ->orderBy('stock', 'asc')
                    ->limit(10)
            )
            ->columns([
                Tables\Columns\TextColumn::make('name')
                    ->label('Product')
                    ->weight('semibold')
                    ->url(fn($record) => ProductsResource::getUrl('edit', ['record' => $record->id])),


                Tables\Columns\TextColumn::make('stock')
                    ->label('Stock')
                    ->formatStateUsing(fn($state) => $state ?? 0)
                    ->color(fn($state) => $state <= 3 ? 'danger' : 'warning')
                    ->badge()
                    ->alignCenter(),

                Tables\Columns\TextColumn::make('status')
                    ->label('Status')
                    ->formatStateUsing(fn($state) => $state <= 3 ? 'Critical' : 'Low Stock')
                    ->color(fn($state) => $state <= 3 ? 'danger' : 'warning')
                    ->badge()
                    ->alignCenter(),
            ])

            ->headerActions([
                Action::make('view_all')
                    ->label('View All')
                    ->color('gray')
                    ->outlined()
                    ->url(fn(): string => ProductsResource::getUrl('index', [
                        'tableFilters' => [
                            'stock_filter' => [
                                'value' => 'low_stock'
                            ]
                        ]
                    ]))
                    ->openUrlInNewTab(false),
            ])

            ->paginated(false)
            ->emptyStateHeading('No Low Stock Products')
            ->emptyStateDescription('All products have sufficient stock.')
            ->emptyStateIcon('heroicon-o-check-circle');
    }
}
