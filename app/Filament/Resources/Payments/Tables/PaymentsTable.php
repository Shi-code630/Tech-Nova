<?php

namespace App\Filament\Resources\Payments\Tables;

use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteAction;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Actions\ViewAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Filters\TernaryFilter;
use Filament\Tables\Table;

class PaymentsTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('id')
                    ->label('ID')
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),

                TextColumn::make('order.order_number')
                    ->label('Order #')
                    ->searchable()
                    ->sortable()
                    ->weight('bold')
                    ->color('primary'),

                TextColumn::make('amount')
                    ->label('Amount')
                    ->money('Rs.')
                    ->sortable()
                    ->weight('bold')
                    ->color('success'),

                TextColumn::make('payment_method')
                    ->label('Method')
                    ->formatStateUsing(fn($state) => match ($state) {
                        'cash' => 'Cash',
                        'card' => 'Card',
                        'bank_transfer' => 'Bank Transfer',
                        'mobile_banking' => 'Mobile Banking',
                        'Cash on Delivery' => 'Cash on Delivery',
                        'esewa' => 'eSewa',
                        'khalti' => 'Khalti',
                        default => ucfirst($state),
                    })
                    ->badge()
                    ->searchable()
                    ->sortable()
                    ->colors([
                        'primary' => ['cash', 'Cash on Delivery'],
                        'warning' => ['card', 'mobile_banking'],
                        'info' => ['bank_transfer'],
                        'success' => ['esewa', 'khalti'],
                    ]),

                TextColumn::make('status')
                    ->label('Status')
                    ->badge()
                    ->sortable()
                    ->colors([
                        'warning' => 'pending',
                        'success' => 'completed',
                        'danger' => 'failed',
                        'secondary' => 'refunded',
                    ]),

                TextColumn::make('transaction_id')
                    ->label('Transaction ID')
                    ->searchable()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),

                TextColumn::make('created_at')
                    ->label('Payment Date')
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
                SelectFilter::make('order_id')
                    ->label('Order')
                    ->relationship('order', 'order_number')
                    ->searchable()
                    ->preload(),

                SelectFilter::make('payment_method')
                    ->label('Payment Method')
                    ->options([
                        'cash' => 'Cash',
                        'card' => 'Card',
                        'bank_transfer' => 'Bank Transfer',
                        'mobile_banking' => 'Mobile Banking',
                        'Cash on Delivery' => 'Cash on Delivery',
                        'esewa' => 'eSewa',
                        'khalti' => 'Khalti',
                    ])
                    ->searchable()
                    ->preload(),

                SelectFilter::make('status')
                    ->label('Payment Status')
                    ->options([
                        'pending' => 'Pending',
                        'completed' => 'Completed',
                        'failed' => 'Failed',
                        'refunded' => 'Refunded',
                    ])
                    ->preload(),

                TernaryFilter::make('created_at')
                    ->label('Today\'s Payments')
                    ->placeholder('All Payments')
                    ->trueLabel('Today\'s Payments')
                    ->falseLabel('Older Payments')
                    ->queries(
                        true: fn($query) => $query->whereDate('created_at', today()),
                        false: fn($query) => $query->whereDate('created_at', '<', today()),
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
                    ->modalHeading('Delete Payment')
                    ->modalDescription('Are you sure you want to delete this payment record? This action cannot be undone.')
                    ->modalSubmitActionLabel('Yes, Delete'),
            ])
            ->bulkActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make()
                        ->label('Delete Selected')
                        ->color('danger')
                        ->icon('heroicon-o-trash')
                        ->requiresConfirmation()
                        ->modalHeading('Delete Selected Payments')
                        ->modalDescription('Are you sure you want to delete the selected payment records? This action cannot be undone.'),
                ]),
            ])
            ->defaultSort('created_at', 'desc')
            ->striped()
            ->paginated([10, 25, 50, 100])
            ->searchable();
    }
}
