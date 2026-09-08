<?php

namespace App\Filament\Resources\Users\Tables;

use Filament\Actions\Action;
use Filament\Actions\BulkAction;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteAction;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\TextInput as FormTextInput;
use Filament\Forms\Components\Select;
use Filament\Notifications\Notification;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Columns\ToggleColumn;
use Filament\Tables\Filters\Filter;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Filters\TernaryFilter;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use App\Helpers\RewardHelper;

class UsersTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('id')
                    ->label('ID')
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true)
                    ->width(80),

                TextColumn::make('name')
                    ->label('Name')
                    ->searchable()
                    ->sortable()
                    ->weight('bold')
                    ->icon('heroicon-o-user')
                    ->width(200),

                TextColumn::make('email')
                    ->label('Email')
                    ->searchable()
                    ->sortable()
                    ->copyable()
                    ->copyMessage('Email copied!')
                    ->icon('heroicon-o-envelope')
                    ->width(250),

                TextColumn::make('phone')
                    ->label('Phone')
                    ->searchable()
                    ->sortable()
                    ->toggleable()
                    ->placeholder('Not provided')
                    ->icon('heroicon-o-phone')
                    ->width(150),

                ToggleColumn::make('status')
                    ->label('Status')
                    ->sortable()
                    ->width(100),

                // ✅ Coins Column (Updated label)
                TextColumn::make('reward_points')
                    ->label('Coins')
                    ->sortable()
                    ->numeric()
                    ->toggleable()
                    ->icon('heroicon-o-star')
                    ->color('warning')
                    ->width(100)
                    ->formatStateUsing(fn ($state) => number_format($state)),

                // ✅ Coin Value Column (NEW)
                TextColumn::make('coins_value')
                    ->label('Coin Value')
                    ->getStateUsing(function ($record) {
                        $redeemRate = RewardHelper::getRedeemRate();
                        return 'Rs. ' . number_format($record->reward_points / $redeemRate, 2);
                    })
                    ->sortable()
                    ->toggleable()
                    ->color('success')
                    ->width(120),

                TextColumn::make('order_count')
                    ->label('Orders')
                    ->counts('orders')
                    ->sortable()
                    ->toggleable()
                    ->badge()
                    ->color('info')
                    ->width(100),

                TextColumn::make('total_spent')
                    ->label('Total Spent')
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true)
                    ->money('NPR')
                    ->width(150),

                TextColumn::make('created_at')
                    ->label('Joined')
                    ->dateTime('M d, Y')
                    ->sortable()
                    ->toggleable()
                    ->width(120),

                TextColumn::make('updated_at')
                    ->label('Updated')
                    ->dateTime('M d, Y')
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true)
                    ->width(120),
            ])
            ->filters([
                SelectFilter::make('status')
                    ->label('Status')
                    ->options([
                        '1' => 'Active',
                        '0' => 'Inactive',
                    ])
                    ->placeholder('All Statuses'),

                TernaryFilter::make('has_orders')
                    ->label('Has Orders')
                    ->placeholder('All Users')
                    ->trueLabel('Has Orders')
                    ->falseLabel('No Orders')
                    ->queries(
                        true: fn ($query) => $query->has('orders'),
                        false: fn ($query) => $query->doesntHave('orders'),
                    ),

                // ✅ Coins Range Filter (Updated)
                Filter::make('reward_points_range')
                    ->label('Coins Range')
                    ->form([
                        FormTextInput::make('points_from')
                            ->label('Coins From')
                            ->numeric()
                            ->minValue(0),
                        FormTextInput::make('points_to')
                            ->label('Coins To')
                            ->numeric()
                            ->minValue(0),
                    ])
                    ->query(function (Builder $query, array $data): Builder {
                        return $query
                            ->when(
                                $data['points_from'],
                                fn (Builder $query, $points): Builder => $query->where('reward_points', '>=', $points),
                            )
                            ->when(
                                $data['points_to'],
                                fn (Builder $query, $points): Builder => $query->where('reward_points', '<=', $points),
                            );
                    }),

                Filter::make('created_at_range')
                    ->label('Registration Date')
                    ->form([
                        DatePicker::make('created_from')
                            ->label('From Date'),
                        DatePicker::make('created_until')
                            ->label('Until Date'),
                    ])
                    ->query(function (Builder $query, array $data): Builder {
                        return $query
                            ->when(
                                $data['created_from'],
                                fn (Builder $query, $date): Builder => $query->whereDate('created_at', '>=', $date),
                            )
                            ->when(
                                $data['created_until'],
                                fn (Builder $query, $date): Builder => $query->whereDate('created_at', '<=', $date),
                            );
                    }),
            ])
            ->filtersFormColumns(2)
            ->filtersLayout(\Filament\Tables\Enums\FiltersLayout::AboveContent)
            ->actions([
                EditAction::make()
                    ->icon('heroicon-o-pencil')
                    ->tooltip('Edit User')
                    ->slideOver()
                    ->modalWidth('md'),

                DeleteAction::make()
                    ->icon('heroicon-o-trash')
                    ->tooltip('Delete User')
                    ->color('danger')
                    ->requiresConfirmation()
                    ->modalHeading('Delete User')
                    ->modalDescription('Are you sure you want to delete this user? This action cannot be undone.')
                    ->modalSubmitActionLabel('Delete'),

                Action::make('view_orders')
                    ->label('View Orders')
                    ->icon('heroicon-o-shopping-cart')
                    ->tooltip('View user orders')
                    ->url(fn ($record) =>
                        url('/admin/orders?tableFilters[user_id][value]=' . $record->id)
                    )
                    ->openUrlInNewTab(),

                // ✅ Manage Coins Action (Updated)
                Action::make('manage_points')
                    ->label('Manage Coins')
                    ->icon('heroicon-o-star')
                    ->tooltip('Manage user coins')
                    ->form([
                        FormTextInput::make('points')
                            ->label('Coins Amount')
                            ->numeric()
                            ->required()
                            ->minValue(1),

                        Select::make('action')
                            ->label('Action')
                            ->options([
                                'add' => 'Add Coins',
                                'deduct' => 'Deduct Coins',
                            ])
                            ->required(),

                        FormTextInput::make('remarks')
                            ->label('Remarks')
                            ->maxLength(255)
                            ->placeholder('Reason for this change'),
                    ])
                    ->action(function ($record, array $data) {
                        try {
                            if ($data['action'] === 'add') {
                                $record->addCoins(
                                    $data['points'],
                                    null,
                                    $data['remarks'] ?? 'Admin adjustment'
                                );
                            } else {
                                $record->redeemCoins(
                                    $data['points'],
                                    null,
                                    $data['remarks'] ?? 'Admin adjustment'
                                );
                            }

                            Notification::make()
                                ->title('Coins Updated')
                                ->body('User coins have been updated successfully.')
                                ->success()
                                ->send();
                        } catch (\Exception $e) {
                            Notification::make()
                                ->title('Error')
                                ->body($e->getMessage())
                                ->danger()
                                ->send();
                        }
                    }),
            ])
            ->bulkActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make()
                        ->icon('heroicon-o-trash')
                        ->tooltip('Delete Selected')
                        ->requiresConfirmation()
                        ->modalHeading('Delete Users')
                        ->modalDescription('Are you sure you want to delete these users? This action cannot be undone.'),

                    BulkAction::make('activate')
                        ->label('Activate Selected')
                        ->icon('heroicon-o-check-circle')
                        ->action(function ($records) {
                            foreach ($records as $record) {
                                $record->update(['status' => true]);
                            }
                            Notification::make()
                                ->title('Users Activated')
                                ->success()
                                ->send();
                        }),

                    BulkAction::make('deactivate')
                        ->label('Deactivate Selected')
                        ->icon('heroicon-o-x-circle')
                        ->color('danger')
                        ->action(function ($records) {
                            foreach ($records as $record) {
                                $record->update(['status' => false]);
                            }
                            Notification::make()
                                ->title('Users Deactivated')
                                ->success()
                                ->send();
                        }),
                ]),
            ])
            ->defaultSort('created_at', 'desc')
            ->searchable()
            ->searchPlaceholder('Search users...')
            ->paginated([10, 25, 50, 100, 'all'])
            ->persistFiltersInSession()
            ->persistSortInSession()
            ->persistSearchInSession()
            ->deferLoading()
            ->striped()
            ->extremePaginationLinks()
            ->poll('10s');
    }
}