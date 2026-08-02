<?php

namespace App\Filament\Resources\Coupons\Tables;

use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteAction;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Actions\ViewAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Columns\ToggleColumn;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Filters\TernaryFilter;
use Filament\Tables\Table;

class CouponsTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('code')
                    ->label('Coupon Code')
                    ->searchable()
                    ->sortable()
                    ->weight('bold')
                    ->color('primary')
                    ->copyable()
                    ->copyMessage('Coupon code copied!'),

                TextColumn::make('type')
                    ->label('Type')
                    ->badge()
                    ->colors([
                        'primary' => 'percentage',
                        'warning' => 'fixed',
                    ])
                    ->formatStateUsing(fn($state) => $state === 'percentage' ? 'Percentage' : 'Fixed'),

                TextColumn::make('discount_formatted')
                    ->label('Discount')
                    ->sortable()
                    ->weight('bold')
                    ->color('success'),

                TextColumn::make('minimum_amount')
                    ->label('Min. Order')
                    ->money('Rs.')
                    ->sortable()
                    ->formatStateUsing(fn($state) => $state ? 'Rs. ' . number_format($state, 2) : 'No min')
                    ->toggleable(isToggledHiddenByDefault: true),

                TextColumn::make('usage_percentage')
                    ->label('Usage')
                    ->formatStateUsing(fn($state) => $state . '%')
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),

                TextColumn::make('remaining_usage')
                    ->label('Remaining')
                    ->badge()
                    ->colors([
                        'success' => 'Unlimited',
                        'warning' => fn($state) => is_numeric($state) && $state <= 10,
                        'danger' => fn($state) => is_numeric($state) && $state == 0,
                        'secondary' => fn($state) => is_numeric($state) && $state > 10,
                    ]),

                TextColumn::make('status_badge')
                    ->label('Status')
                    ->badge()
                    ->colors([
                        'success' => 'Active',
                        'danger' => 'Inactive',
                        'warning' => 'Expired',
                        'info' => 'Upcoming',
                        'secondary' => 'Used Up',
                    ]),

                ToggleColumn::make('status')
                    ->label('Enabled')
                    ->sortable(),

                TextColumn::make('start_date')
                    ->label('Start Date')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),

                TextColumn::make('expire_date')
                    ->label('Expire Date')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),

                TextColumn::make('created_at')
                    ->label('Created')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                SelectFilter::make('type')
                    ->label('Discount Type')
                    ->options([
                        'percentage' => 'Percentage',
                        'fixed' => 'Fixed Amount',
                    ])
                    ->preload(),

                SelectFilter::make('status_badge')
                    ->label('Status')
                    ->options([
                        'Active' => 'Active',
                        'Inactive' => 'Inactive',
                        'Expired' => 'Expired',
                        'Upcoming' => 'Upcoming',
                        'Used Up' => 'Used Up',
                    ])
                    ->preload(),

                TernaryFilter::make('status')
                    ->label('Enabled Status')
                    ->placeholder('All Coupons')
                    ->trueLabel('Enabled Only')
                    ->falseLabel('Disabled Only'),

                TernaryFilter::make('is_valid')
                    ->label('Validity')
                    ->placeholder('All Coupons')
                    ->trueLabel('Valid Only')
                    ->falseLabel('Invalid Only')
                    ->queries(
                        true: fn($query) => $query->valid(),
                        false: fn($query) => $query->where('status', false)
                            ->orWhere('expire_date', '<', now())
                            ->orWhereRaw('usage_limit IS NOT NULL AND used >= usage_limit'),
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
                    ->modalHeading('Delete Coupon')
                    ->modalDescription('Are you sure you want to delete this coupon? This action cannot be undone.')
                    ->modalSubmitActionLabel('Yes, Delete'),
            ])
            ->bulkActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make()
                        ->label('Delete Selected')
                        ->color('danger')
                        ->icon('heroicon-o-trash')
                        ->requiresConfirmation()
                        ->modalHeading('Delete Selected Coupons')
                        ->modalDescription('Are you sure you want to delete the selected coupons? This action cannot be undone.'),
                ]),
            ])
            ->defaultSort('created_at', 'desc')
            ->striped()
            ->paginated([10, 25, 50, 100])
            ->searchable();
    }
}
