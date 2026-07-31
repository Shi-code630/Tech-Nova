<?php

namespace App\Filament\Resources\RewardTransactions\Tables;

use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteAction;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Actions\ViewAction;
use Filament\Forms\Components\DatePicker;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\Filter;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Table;

class RewardTransactionsTable
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

                TextColumn::make('type')
                    ->label('Type')
                    ->badge()
                    ->color(fn ($record) => $record->type_badge)
                    ->formatStateUsing(fn ($record) => $record->type_label)
                    ->sortable(),

                TextColumn::make('points')
                    ->label('Points')
                    ->formatStateUsing(function ($record) {
                        $prefix = $record->type === 'earned' ? '+' : '-';
                        return $prefix . number_format($record->points);
                    })
                    ->color(fn ($record) => $record->type === 'earned' ? 'success' : 'danger')
                    ->weight('bold')
                    ->sortable(),

                TextColumn::make('order.order_number')
                    ->label('Order #')
                    ->searchable()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),

                TextColumn::make('remarks')
                    ->label('Remarks')
                    ->limit(30)
                    ->toggleable()
                    ->tooltip(fn ($record) => $record->remarks),

                TextColumn::make('created_at')
                    ->label('Date')
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

                SelectFilter::make('type')
                    ->label('Transaction Type')
                    ->options([
                        'earned' => 'Earned Points',
                        'redeemed' => 'Redeemed Points',
                    ])
                    ->preload(),

                SelectFilter::make('order_id')
                    ->label('Order')
                    ->relationship('order', 'order_number')
                    ->searchable()
                    ->preload(),

                Filter::make('created_at')
                    ->label('Date Range')
                    ->form([
                        DatePicker::make('created_from')
                            ->label('From'),
                        DatePicker::make('created_until')
                            ->label('Until'),
                    ])
                    ->query(function ($query, array $data) {
                        return $query
                            ->when($data['created_from'], fn ($q) => $q->whereDate('created_at', '>=', $data['created_from']))
                            ->when($data['created_until'], fn ($q) => $q->whereDate('created_at', '<=', $data['created_until']));
                    }),
            ])
            ->recordActions([
                ViewAction::make()
                    ->label('View')
                   ->color('warning')
                    ->icon('heroicon-o-eye'),


                EditAction::make()
                    ->label('Edit')
                    ->color('warning')
                    ->icon('heroicon-o-pencil-square')
                  ,

                DeleteAction::make()
                    ->label('Delete')
                   ->color('warning')
                    ->icon('heroicon-o-trash')

                    ->requiresConfirmation()
                    ->modalHeading('Delete Transaction')
                    ->modalDescription('Are you sure you want to delete this transaction? This action cannot be undone.')
                    ->modalSubmitActionLabel('Yes, Delete'),
            ])
            ->bulkActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make()
                        ->label('Delete Selected')
                        ->color('danger')
                        ->icon('heroicon-o-trash')
                        ->requiresConfirmation()
                        ->modalHeading('Delete Selected Transactions')
                        ->modalDescription('Are you sure you want to delete the selected transactions? This action cannot be undone.'),
                ]),
            ])
            ->defaultSort('created_at', 'desc')
            ->striped()
            ->paginated([10, 25, 50, 100])
            ->searchable(['user.name', 'order.order_number', 'remarks']);
    }
}
