<?php

namespace App\Filament\Widgets\Dashboard;

use App\Filament\Resources\Products\ProductsResource;
use App\Models\Product;
use Filament\Actions\Action;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Filament\Widgets\TableWidget;
use Illuminate\Database\Eloquent\Builder;

class LowStockAlert extends TableWidget
{
    protected static ?string $heading = 'Low Stock Alert';
    protected static ?int $sort = 5;
    protected int|string|array $columnSpan = [
        'default' => 1,
        'md' => 2,
        'xl' => 7,
    ];


    public function table(Table $table): Table
    {
        return $table
            ->query(
                fn(): Builder => Product::query()
                    ->where('stock', '<=', 5)
                    ->orderBy('stock', 'asc')
            )
            ->columns([
                TextColumn::make('name')
                    ->label('Product')
                    ->weight('semibold'),
                TextColumn::make('stock')
                    ->label('Stock')
                    ->badge()
                    ->color(
                        fn(int $state): string =>
                        $state <= 2 ? 'danger' : 'warning'
                    )
                    ->formatStateUsing(
                        fn(int $state): string =>
                        "Stock: {$state}"
                    ),
                TextColumn::make('status')
                    ->label('Status')
                    ->badge()
                    ->getStateUsing(
                        fn($record): string =>
                        'Low Stock'
                    )
                    ->color(
                        fn($record): string =>
                        $record->stock <= 2 ? 'danger' : 'warning'
                    ),
            ])
            ->headerActions([
                Action::make('viewAll')
                    ->label('View All stock')
                    ->icon('heroicon-o-eye')
                    ->url(ProductsResource::getUrl('index')),

            ])
            ->paginated(false)
            ->defaultSort('stock', 'asc');
    }
}
