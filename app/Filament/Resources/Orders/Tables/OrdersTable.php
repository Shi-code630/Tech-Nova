<?php

namespace App\Filament\Resources\Orders\Tables;

use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteAction;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Actions\ViewAction;
use Filament\Tables\Columns\BadgeColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Filters\TernaryFilter;
use Filament\Tables\Table;

class OrdersTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('order_number')
                    ->label('Order #')
                    ->searchable()
                    ->sortable()
                    ->copyable(),

                TextColumn::make('user.name')
                    ->label('Customer')
                    ->searchable()
                    ->sortable(),

                TextColumn::make('grand_total')
                    ->label('Total')
                    ->money('Rs.')
                    ->sortable(),

                TextColumn::make('items_count')
                    ->label('Items')
                    ->counts('items')
                    ->sortable(),

                TextColumn::make('order_status')
                    ->label('Order Status')
                    ->badge()
                    ->color(fn ($record) => match($record->order_status) {
                        'pending' => 'warning',
                        'processing' => 'info',
                        'shipped' => 'primary',
                        'delivered' => 'success',
                        'cancelled' => 'danger',
                        default => 'secondary',
                    }),

                TextColumn::make('payment_status')
                    ->label('Payment')
                    ->badge()
                    ->color(fn ($record) => match($record->payment_status) {
                        'pending' => 'warning',
                        'paid' => 'success',
                        'failed' => 'danger',
                        'refunded' => 'secondary',
                        default => 'secondary',
                    }),

                TextColumn::make('payment_method')
                    ->label('Payment Method')
                    ->searchable()
                    ->toggleable(isToggledHiddenByDefault: true),

                TextColumn::make('created_at')
                    ->label('Order Date')
                    ->dateTime()
                    ->sortable(),

                TextColumn::make('updated_at')
                    ->label('Updated')
                    ->dateTime()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                SelectFilter::make('order_status')
                    ->label('Order Status')
                    ->options([
                        'pending' => 'Pending',
                        'processing' => 'Processing',
                        'shipped' => 'Shipped',
                        'delivered' => 'Delivered',
                        'cancelled' => 'Cancelled',
                    ]),

                SelectFilter::make('payment_status')
                    ->label('Payment Status')
                    ->options([
                        'pending' => 'Pending',
                        'paid' => 'Paid',
                        'failed' => 'Failed',
                        'refunded' => 'Refunded',
                    ]),

                SelectFilter::make('payment_method')
                    ->label('Payment Method')
                    ->options([
                        'cash' => 'Cash',
                        'card' => 'Card',
                        'bank_transfer' => 'Bank Transfer',
                        'mobile_banking' => 'Mobile Banking',
                    ])
                    ->searchable(),

                TernaryFilter::make('created_at')
                    ->label('Recent Orders')
                    ->placeholder('All Orders')
                    ->trueLabel('Today\'s Orders')
                    ->falseLabel('Older Orders')
                    ->queries(
                        true: fn ($query) => $query->whereDate('created_at', today()),
                        false: fn ($query) => $query->whereDate('created_at', '<', today()),
                    ),
            ])
            ->recordActions([
                ViewAction::make()
                    ->label('View')
                ->color('warning')
                    ->icon('heroicon-o-eye')

                    ->size('sm'),

                EditAction::make()
                    ->label('Edit')
                    ->color('warning')
                    ->icon('heroicon-o-pencil-square')

                    ->size('sm'),

                DeleteAction::make()
                    ->label('Delete')
                     ->color('warning')
                    ->icon('heroicon-o-trash')

                    ->size('sm')
                    ->requiresConfirmation()
                    ->modalHeading('Delete Order')
                    ->modalDescription('Are you sure you want to delete this order? This action cannot be undone.'),
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
