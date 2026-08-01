<?php

namespace App\Filament\Resources\ProductVariants\Tables;

use App\Models\ProductVariant;
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

class ProductVariantsTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                ImageColumn::make('image')
                    ->label('Image')
                    ->square()
                    ->size(50),

                TextColumn::make('product.name')
                    ->label('Product')
                    ->searchable()
                    ->sortable()
                    ->description(fn ($record) => $record->product?->category?->name),

                TextColumn::make('full_name')
                    ->label('Variant')
                    ->searchable(['color', 'size'])
                    ->toggleable(),

                TextColumn::make('color')
                    ->label('Color')
                    ->searchable()
                    ->toggleable(isToggledHiddenByDefault: true),

                TextColumn::make('size')
                    ->label('Size')
                    ->searchable()
                    ->toggleable(isToggledHiddenByDefault: true),

                TextColumn::make('price')
                    ->label('Price')
                    ->money('Rs.')
                    ->sortable(),

                TextColumn::make('stock')
                    ->label('Stock')
                    ->numeric()
                    ->sortable()
                    ->color(fn ($record) => $record->stock > 10 ? 'success' : ($record->stock > 0 ? 'warning' : 'danger')),

                TextColumn::make('stock_status')
                    ->label('Status')
                    ->badge()
                    ->color(fn ($record) => $record->stock_status_color),

                ToggleColumn::make('status')
                    ->label('Active')
                    ->sortable(),

                TextColumn::make('created_at')
                    ->label('Created')
                    ->dateTime()
                    ->toggleable(isToggledHiddenByDefault: true),

                TextColumn::make('updated_at')
                    ->label('Updated')
                    ->dateTime()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                SelectFilter::make('product_id')
                    ->label('Product')
                    ->relationship('product', 'name')
                    ->preload()
                    ->searchable(),

                SelectFilter::make('color')
                    ->label('Color')
                    ->options(function () {
                        return \App\Models\ProductVariant::distinct('color')
                            ->pluck('color', 'color')
                            ->filter()
                            ->toArray();
                    })
                    ->preload(),

                SelectFilter::make('size')
                    ->label('Size')
                    ->options(function () {
                        return \App\Models\ProductVariant::distinct('size')
                            ->pluck('size', 'size')
                            ->filter()
                            ->toArray();
                    })
                    ->preload(),

                TernaryFilter::make('status')
                    ->label('Active Status')
                    ->placeholder('All Variants')
                    ->trueLabel('Active Only')
                    ->falseLabel('Inactive Only'),

                TernaryFilter::make('stock')
                    ->label('Stock Status')
                    ->placeholder('All Stock Levels')
                    ->trueLabel('In Stock (> 0)')
                    ->falseLabel('Out of Stock (0)')
                    ->queries(
                        true: fn ($query) => $query->where('stock', '>', 0),
                        false: fn ($query) => $query->where('stock', '=', 0),
                    ),
            ])
            ->recordActions([

                ViewAction::make()
                    ->label('View')
                    ->color('warning')
                    ->icon('heroicon-o-eye'),


                EditAction::make()
                    ->label('Edit')
                  ->color('warning')
                    ->icon('heroicon-o-pencil-square'),




                DeleteAction::make()
                    ->label('Delete')
                    ->color('warning')
                    ->icon('heroicon-o-trash')
                    ->requiresConfirmation()
                    ->modalHeading('Delete Product Variant')
                    ->modalDescription('Are you sure you want to delete this product variant? This action cannot be undone.')
                    ->modalSubmitActionLabel('Yes, Delete'),
            ])
            ->bulkActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make()
                        ->color('danger'),
                ]),
            ])
            ->defaultSort('created_at', 'desc');
    }
}
