<?php

namespace App\Filament\Widgets\Dashboard;

use App\Filament\Resources\Products\ProductsResource;
use App\Models\Product;
use Filament\Actions\Action;
use Filament\Tables;
use Filament\Tables\Table;
use Filament\Widgets\TableWidget as BaseWidget;
use Illuminate\Database\Eloquent\Builder;

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
                fn (): Builder => Product::query()
                    ->withSum('orderItems as sold', 'quantity')
                    ->withSum('orderItems as revenue', 'total')
                    ->orderByDesc('sold')
                    ->limit(5)
            )
            ->columns([
                Tables\Columns\ImageColumn::make('image')
                    ->label('')
                    ->circular()
                    ->size(36),

                Tables\Columns\TextColumn::make('name')
                    ->label('Product')
                    ->weight('semibold'),

                Tables\Columns\TextColumn::make('sold')
                    ->label('Sold')
                    ->formatStateUsing(fn ($state) => $state ?? 0),

                Tables\Columns\TextColumn::make('revenue')
                    ->label('Revenue')
                    ->formatStateUsing(fn ($state) => 'Rs. ' . number_format($state ?? 0)),
            ])
            ->paginated(false)
            ->headerActions([
                Action::make('viewAll')
                    ->label('View All Products')
                    ->url(ProductsResource::getUrl('index'))
                    ->outlined(),
            ]);
    }
}
