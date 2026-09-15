<?php

namespace App\Filament\Resources\Products\Tables;

use App\Models\Product;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteAction;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Actions\ViewAction;
use Filament\Tables\Columns\ImageColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Columns\ToggleColumn;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Filters\TernaryFilter;
use Filament\Tables\Table;

class ProductsTable
{

    protected static function effectiveStockSql(): string
    {
        return '
            CASE
                WHEN (SELECT COUNT(*) FROM product_variants WHERE product_variants.product_id = products.id) > 0
                THEN (SELECT COALESCE(SUM(stock), 0) FROM product_variants WHERE product_variants.product_id = products.id)
                ELSE products.stock
            END
        ';
    }

    public static function configure(Table $table): Table
    {
        return $table
            ->modifyQueryUsing(
                fn ($query) => $query
                    ->withCount('variants')
                    ->selectRaw(self::effectiveStockSql() . ' as effective_stock')
            )

            ->poll('15s')
            ->columns([

                ImageColumn::make('thumbnails')
                    ->label('Image')
                    ->disk('public')
                    ->square()
                    ->size(50),

                TextColumn::make('name')
                    ->label('Product Name')
                    ->searchable()
                    ->sortable(),

                TextColumn::make('category.name')
                    ->label('Category')
                    ->searchable()
                    ->sortable()
                    ->toggleable(),

                TextColumn::make('brand.name')
                    ->label('Brand')
                    ->searchable()
                    ->sortable()
                    ->toggleable(
                        isToggledHiddenByDefault: true
                    ),

                               TextColumn::make('price')
                    ->label('Price')
                    ->formatStateUsing(fn ($state) => 'Rs. ' . number_format((float) $state, 2))
                    ->sortable(),

                TextColumn::make('discount_price')
                    ->label('Discount')
                    ->formatStateUsing(fn ($state) => $state ? 'Rs. ' . number_format((float) $state, 2) : '—')
                    ->sortable()
                    ->toggleable(
                        isToggledHiddenByDefault: true
                    ),

                TextColumn::make('final_price')
                    ->label('Final Price')
                    ->formatStateUsing(fn ($state) => 'Rs. ' . number_format((float) $state, 2))
                    ->sortable(),

                TextColumn::make('effective_stock')
                    ->label('Stock')
                    ->formatStateUsing(fn ($state) => number_format((int) $state))
                    ->sortable()
                    ->tooltip(
                        fn ($record) => $record->variants_count > 0
                            ? 'Sum of stock across ' . $record->variants_count . ' variant(s)'
                            : 'Product stock (no variants)'
                    )
                    ->color(
                        fn ($record) =>
                            $record->effective_stock > 10
                                ? 'success'
                                : (
                                    $record->effective_stock > 0
                                        ? 'warning'
                                        : 'danger'
                                )
                    ),

                TextColumn::make('variants_count')
                    ->label('Variants')
                    ->badge()
                    ->color('info'),

                TextColumn::make('status')
                    ->label('Status')
                    ->badge()
                    ->color(
                        fn ($record) => match ($record->status) {
                            'active' => 'success',
                            'inactive' => 'danger',
                            'out_of_stock' => 'warning',
                            default => 'gray',
                        }
                    ),

                ToggleColumn::make('featured')
                    ->label('Featured')
                    ->sortable(),

                TextColumn::make('created_at')
                    ->label('Created')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(
                        isToggledHiddenByDefault: true
                    ),
            ])

            ->filters([

                SelectFilter::make('category_id')
                    ->label('Category')
                    ->relationship('category', 'name')
                    ->preload()
                    ->searchable(),

                SelectFilter::make('brand_id')
                    ->label('Brand')
                    ->relationship('brand', 'name')
                    ->preload()
                    ->searchable(),

                SelectFilter::make('status')
                    ->label('Status')
                    ->options([
                        'active' => 'Active',
                        'inactive' => 'Inactive',
                        'out_of_stock' => 'Out of Stock',
                    ]),

                TernaryFilter::make('featured')
                    ->label('Featured')
                    ->placeholder('All Products')
                    ->trueLabel('Featured Only')
                    ->falseLabel('Non-Featured Only'),

                // Now checks the SAME variant-aware stock as the column
                // above, instead of the raw products.stock column.
                TernaryFilter::make('stock_status')
                    ->label('Stock Status')
                    ->placeholder('All Stock Levels')
                    ->trueLabel('In Stock')
                    ->falseLabel('Out of Stock')
                    ->queries(
                        true: fn ($query) =>
                            $query->whereRaw(self::effectiveStockSql() . ' > 0'),

                        false: fn ($query) =>
                            $query->whereRaw(self::effectiveStockSql() . ' <= 0'),
                    ),
            ])

            ->recordActions([

                ViewAction::make()
                    ->label('View')
                    ->icon('heroicon-o-eye'),

                EditAction::make()
                    ->label('Edit')
                    ->icon('heroicon-o-pencil-square'),

                DeleteAction::make()
                    ->label('Delete')
                    ->icon('heroicon-o-trash')
                    ->requiresConfirmation(),
            ])

            ->bulkActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                ]),
            ])

            ->defaultSort('created_at', 'desc');
    }
}
