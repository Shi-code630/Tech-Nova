<?php

namespace App\Filament\Resources\Wishlists\Tables;

use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteAction;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Actions\ViewAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Table;

class WishlistsTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('id')
                    ->label('ID')
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),

                TextColumn::make('user.name')
                    ->label('Customer')
                    ->searchable()
                    ->sortable()
                    ->weight('bold')
                    ->icon('heroicon-o-user'),

                TextColumn::make('product.name')
                    ->label('Product')
                    ->searchable()
                    ->sortable()
                    ->limit(40)
                    ->weight('medium'),

                TextColumn::make('product.price')
                    ->label('Price')
                    ->money('Rs.')
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),

                TextColumn::make('created_at')
                    ->label('Added')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(),

                TextColumn::make('updated_at')
                    ->label('Updated')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                SelectFilter::make('user_id')
                    ->label('Customer')
                    ->relationship('user', 'name')
                    ->searchable()
                    ->preload(),

                SelectFilter::make('product_id')
                    ->label('Product')
                    ->relationship('product', 'name')
                    ->searchable()
                    ->preload(),
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
                    ->modalHeading('Delete Wishlist Item')
                    ->modalDescription('Are you sure you want to remove this item from the wishlist? This action cannot be undone.')
                    ->modalSubmitActionLabel('Yes, Delete'),
            ])
            ->bulkActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make()
                        ->label('Delete Selected')
                        ->color('warning')
                        ->icon('heroicon-o-trash')
                        ->requiresConfirmation()
                        ->modalHeading('Delete Selected Items')
                        ->modalDescription('Are you sure you want to delete the selected wishlist items? This action cannot be undone.'),
                ]),
            ])
            ->defaultSort('created_at', 'desc')
            ->striped()
            ->paginated([10, 25, 50, 100])
            ->searchable(['product.name', 'user.name']);
    }
}
