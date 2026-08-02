<?php

namespace App\Filament\Resources\UserAddresses\Tables;

use App\Models\User;
use Filament\Actions\Action;
use Filament\Actions\BulkAction;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteAction;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Notifications\Notification;
use Filament\Tables\Columns\BadgeColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Columns\ToggleColumn;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Filters\TernaryFilter;
use Filament\Tables\Table;


class UserAddressesTable
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

                TextColumn::make('user.name')
                    ->label('User')
                    ->searchable()
                    ->sortable()
                    ->weight('bold')
                    ->icon('heroicon-o-user')
                    ->width(150),

                TextColumn::make('full_name')
                    ->label('Full Name')
                    ->searchable()
                    ->sortable()
                    ->width(150),

                TextColumn::make('phone')
                    ->label('Phone')
                    ->searchable()
                    ->sortable()
                    ->width(150),

                TextColumn::make('city')
                    ->label('City')
                    ->searchable()
                    ->sortable()
                    ->width(120),

                TextColumn::make('district')
                    ->label('District')
                    ->searchable()
                    ->sortable()
                    ->toggleable()
                    ->width(120),

                TextColumn::make('province')
                    ->label('Province')
                    ->searchable()
                    ->sortable()
                    ->toggleable()
                    ->width(120),

                TextColumn::make('full_address')
                    ->label('Full Address')
                    ->limit(50)
                    ->toggleable(isToggledHiddenByDefault: true)
                    ->width(200),

                ToggleColumn::make('is_default')
                    ->label('Default')
                    ->sortable()
                    ->width(100),

                TextColumn::make('orders_count')
                    ->label('Orders')
                    ->counts('orders')
                    ->sortable()
                    ->toggleable()
                    ->badge()
                    ->color('info')
                    ->width(100),

                TextColumn::make('created_at')
                    ->label('Created')
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
                SelectFilter::make('user_id')
                    ->label('User')
                    ->options(User::query()->pluck('name', 'id'))
                    ->searchable()
                    ->preload()
                    ->placeholder('All Users'),

                SelectFilter::make('province')
                    ->label('Province')
                    ->options(fn() => \App\Models\Address::distinct()->pluck('province', 'province'))
                    ->searchable()
                    ->preload()
                    ->placeholder('All Provinces'),

                SelectFilter::make('district')
                    ->label('District')
                    ->options(fn() => \App\Models\Address::distinct()->pluck('district', 'district'))
                    ->searchable()
                    ->preload()
                    ->placeholder('All Districts'),

                TernaryFilter::make('is_default')
                    ->label('Default Address')
                    ->placeholder('All Addresses')
                    ->trueLabel('Default Address')
                    ->falseLabel('Non-Default Address')
                    ->queries(
                        true: fn($query) => $query->where('is_default', true),
                        false: fn($query) => $query->where('is_default', false),
                    ),
            ])
            ->filtersFormColumns(2)
            ->filtersLayout(\Filament\Tables\Enums\FiltersLayout::AboveContent)
            ->actions([
                EditAction::make()
                    ->icon('heroicon-o-pencil')
                    ->tooltip('Edit Address')
                    ->slideOver()
                    ->modalWidth('md'),
                DeleteAction::make()
                    ->icon('heroicon-o-trash')
                    ->tooltip('Delete User')
                    ->color('danger')
                    ->requiresConfirmation()
                    ->modalHeading('Delete User')
                    ->modalDescription('Are you sure you want to delete this user? This action cannot be undone.')
                    ->modalSubmitActionLabel('Delete')
                    ->successNotificationTitle('User deleted successfully'),
                // Action::make('set_default')
                //     ->label('Set as Default')
                //     ->icon('heroicon-o-check-circle')
                //     ->color('success')
                //     ->tooltip('Set this as default address')
                //     ->visible(fn($record) => !$record->is_default)
                //     ->action(function ($record) {
                //         // Set this address as default
                //         $record->update(['is_default' => true]);

                //         // Update other addresses of same user
                //         \App\Models\Address::where('user_id', $record->user_id)
                //             ->where('id', '!=', $record->id)
                //             ->update(['is_default' => false]);

                //         Notification::make()
                //             ->title('Default Address Updated')
                //             ->body('This address has been set as default.')
                //             ->success()
                //             ->send();
                //     }),

                Action::make('view_user')
                    ->label('View User')
                    ->icon('heroicon-o-user')
                    ->tooltip('View this user')
                    ->url(
                        fn($record) =>
                        '/admin/users/' . $record->user_id . '/edit'
                    )
                    ->openUrlInNewTab(),
            ])
            ->bulkActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make()
                        ->icon('heroicon-o-trash')
                        ->tooltip('Delete Selected')
                        ->requiresConfirmation()
                        ->modalHeading('Delete Addresses')
                        ->modalDescription('Are you sure you want to delete these addresses? This action cannot be undone.')
                        ->modalSubmitActionLabel('Yes, Delete'),

                    BulkAction::make('set_default_bulk')
                        ->label('Set as Default')
                        ->icon('heroicon-o-check-circle')
                        ->color('success')
                        ->requiresConfirmation()
                        ->modalHeading('Set Default Address')
                        ->modalDescription('Only the first selected address will be set as default.')
                        ->action(function ($records) {
                            $firstRecord = $records->first();
                            if ($firstRecord) {
                                // Set first record as default
                                $firstRecord->update(['is_default' => true]);

                                // Update other addresses of same user
                                \App\Models\Address::where('user_id', $firstRecord->user_id)
                                    ->where('id', '!=', $firstRecord->id)
                                    ->update(['is_default' => false]);

                                Notification::make()
                                    ->title('Default Address Updated')
                                    ->body('The selected address has been set as default.')
                                    ->success()
                                    ->send();
                            }
                        }),
                ]),
            ])
            ->defaultSort('created_at', 'desc')
            ->searchable()
            ->searchPlaceholder('Search addresses...')
            ->paginated([10, 25, 50, 100])
            ->persistFiltersInSession()
            ->persistSortInSession()
            ->persistSearchInSession()
            ->striped()
            ->extremePaginationLinks()
            ->poll('10s');
    }
}
