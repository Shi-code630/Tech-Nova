<?php


namespace App\Filament\Resources\Orders\Tables;

use App\Models\OrderTracking;
use Filament\Actions\Action;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteAction;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Actions\ViewAction;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\Placeholder;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Notifications\Notification;
use Filament\Tables;
use Filament\Tables\Columns\BadgeColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\Filter;
use Filament\Tables\Filters\SelectFilter;
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

                BadgeColumn::make('order_status')
                    ->label('Status')
                    ->colors([
                        'warning' => 'pending',
                        'info' => 'processing',
                        'primary' => 'shipped',
                        'warning' => 'out_for_delivery',
                        'success' => 'delivered',
                        'danger' => 'cancelled',
                        'gray' => 'returned',
                    ])
                    ->formatStateUsing(fn($state) => ucfirst(str_replace('_', ' ', $state))),

                TextColumn::make('current_location')
                    ->label('Location')
                    ->limit(25)
                    ->toggleable(),

                TextColumn::make('tracking_number')
                    ->label('Tracking')
                    ->limit(15)
                    ->toggleable(),

                TextColumn::make('grand_total')
                    ->label('Total')
                    ->money('NPR')
                    ->sortable(),

                BadgeColumn::make('payment_status')
                    ->label('Payment')
                    ->colors([
                        'warning' => 'pending',
                        'success' => 'paid',
                        'danger' => 'failed',
                        'gray' => 'refunded',
                    ]),

                TextColumn::make('created_at')
                    ->label('Order Date')
                    ->formatStateUsing(fn($state) => $state ? $state->timezone('Asia/Kathmandu')->format('d M Y, h:i A') : '-')
                    ->sortable()
                    ->toggleable(),
            ])
            ->filters([
                SelectFilter::make('order_status')
                    ->label('Status')
                    ->options([
                        'pending' => 'Pending',
                        'processing' => 'Processing',
                        'shipped' => 'Shipped',
                        'out_for_delivery' => 'Out for Delivery',
                        'delivered' => 'Delivered',
                        'cancelled' => 'Cancelled',
                        'returned' => 'Returned',
                    ]),

                SelectFilter::make('payment_status')
                    ->label('Payment')
                    ->options([
                        'pending' => 'Pending',
                        'paid' => 'Paid',
                        'failed' => 'Failed',
                        'refunded' => 'Refunded',
                    ]),

                Filter::make('created_at')
                    ->label('Date Range')
                    ->form([
                        DatePicker::make('created_from')->label('From'),
                        DatePicker::make('created_until')->label('Until'),
                    ])
                    ->query(function ($query, array $data) {
                        return $query
                            ->when($data['created_from'], fn($q) => $q->whereDate('created_at', '>=', $data['created_from']))
                            ->when($data['created_until'], fn($q) => $q->whereDate('created_at', '<=', $data['created_until']));
                    }),
            ])
            ->actions([
                ViewAction::make()
                    ->label('View')
                    ->icon('heroicon-o-eye')
                    ->color('warning'),

                EditAction::make()
                    ->label('Edit')
                    ->icon('heroicon-o-pencil-square')
                    ->color('warning'),


                Action::make('updateTracking')
                    ->label('Update Tracking')
                    ->icon('heroicon-o-map-pin')
                    ->color('warning')
                    ->slideOver()
                    ->form([
                        Select::make('order_status')
                            ->label('Status')
                            ->options([
                                'pending' => 'Pending',
                                'processing' => 'Processing',
                                'shipped' => 'Shipped',
                                'out_for_delivery' => 'Out for Delivery',
                                'delivered' => 'Delivered',
                                'cancelled' => 'Cancelled',
                                'returned' => 'Returned',
                            ])
                            ->required()
                            ->native(false),

                        TextInput::make('current_location')
                            ->label('Location')
                            ->placeholder('e.g. Kathmandu Sorting Hub')
                            ->required()
                            ->maxLength(255),

                        TextInput::make('tracking_number')
                            ->label('Tracking Number')
                            ->placeholder('e.g. TRK-123456')
                            ->maxLength(255),

                        TextInput::make('courier_name')
                            ->label('Courier Name')
                            ->placeholder('e.g. DHL, FedEx')
                            ->maxLength(255),

                        Textarea::make('note')
                            ->label('Note')
                            ->placeholder('Add a note about this update...')
                            ->rows(2),
                    ])
                    ->fillForm(fn($record): array => [
                        'order_status' => $record->order_status,
                        'current_location' => $record->current_location,
                        'tracking_number' => $record->tracking_number,
                        'courier_name' => $record->courier_name,
                    ])
                    ->action(function ($record, array $data): void {
                        // Update order
                        $record->update([
                            'order_status' => $data['order_status'],
                            'current_location' => $data['current_location'],
                            'tracking_number' => $data['tracking_number'] ?? null,
                            'courier_name' => $data['courier_name'] ?? null,
                        ]);

                        // Set shipped_at
                        if ($data['order_status'] === 'shipped' && !$record->shipped_at) {
                            $record->update(['shipped_at' => now()]);
                        }

                        // Set delivered_at
                        if ($data['order_status'] === 'delivered' && !$record->delivered_at) {
                            $record->update(['delivered_at' => now()]);
                        }

                        // Add tracking history
                        OrderTracking::create([
                            'order_id' => $record->id,
                            'tracking_number' => $data['tracking_number'] ?? $record->tracking_number,
                            'courier_name' => $data['courier_name'] ?? $record->courier_name,
                            'status' => $data['order_status'],
                            'location' => $data['current_location'],
                            'description' => $data['note'] ?? "Order status updated to " . ucfirst($data['order_status']),
                            'status_date' => now(),
                        ]);

                        Notification::make()
                            ->title('Tracking Updated')
                            ->success()
                            ->body("Order #{$record->order_number} status updated to " . ucfirst($data['order_status']))
                            ->send();
                    }),

                DeleteAction::make()
                    ->label('Delete')
                    ->icon('heroicon-o-trash')
                    ->requiresConfirmation(),

                // ✅ View Tracking History
                Action::make('viewTracking')
                    ->label('Track History')
                    ->icon('heroicon-o-clock')
                    ->slideOver()
                    ->modalHeading('Order Tracking History')
                    ->modalDescription(fn($record) => "Order #{$record->order_number}")
                    ->form(fn($record) => [
                        Placeholder::make('tracking_history')
                            ->label('')
                            ->content(function () use ($record) {
                                $history = '';
                                foreach ($record->trackings()->latest('status_date')->get() as $track) {
                                    $history .= "• " . $track->status_date->format('d M Y, h:i A') . " - ";
                                    $history .= ucfirst($track->status) . " at " . ($track->location ?? 'N/A') . "\n";
                                }
                                return $history ?: 'No tracking history available.';
                            }),
                    ])
                    ->modalSubmitAction(false),
            ])
            ->bulkActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                ]),
            ])
            ->defaultSort('created_at', 'desc');
    }
}
