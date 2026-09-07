<?php

namespace App\Filament\Resources\ReturnRequests\Tables;

use App\Models\OrderItem;
use App\Models\Product;
use App\Models\ProductVariant;
use App\Models\ReturnRequest;
use Filament\Actions\Action;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Actions\ViewAction;
use Filament\Forms\Components\Textarea;
use Filament\Tables\Columns\ImageColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Table;
use Illuminate\Support\Facades\DB;

class ReturnRequestsTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('id')
                    ->label('Request #')
                    ->sortable(),

                TextColumn::make('order.order_number')
                    ->label('Order #')
                    ->searchable()
                    ->sortable(),

                TextColumn::make('user.name')
                    ->label('Customer')
                    ->searchable()
                    ->sortable(),

                TextColumn::make('orderItem.product.name')
                    ->label('Product')
                    ->searchable()
                    ->limit(35),

                TextColumn::make('request_type_label')
                    ->label('Type')
                    ->badge()
                    ->color(fn (ReturnRequest $record): string => $record->request_type === 'exchange'
                        ? 'info'
                        : 'warning'),

                TextColumn::make('quantity')
                    ->label('Qty')
                    ->alignCenter()
                    ->sortable(),

                TextColumn::make('status_label')
                    ->label('Status')
                    ->badge()
                    ->color(fn (ReturnRequest $record): string => $record->status_color),

                ImageColumn::make('image')
                    ->label('Photo')
                    ->disk('public')
                    ->square(),

                TextColumn::make('created_at')
                    ->label('Requested')
                    ->dateTime()
                    ->sortable(),
            ])
            ->filters([
                SelectFilter::make('request_type')
                    ->label('Type')
                    ->options([
                        'return' => 'Return',
                        'exchange' => 'Exchange',
                    ]),

                SelectFilter::make('status')
                    ->options([
                        'requested' => 'Requested',
                        'approved' => 'Approved',
                        'rejected' => 'Rejected',
                        'received' => 'Received',
                        'completed' => 'Completed',
                    ]),
            ])
            ->recordActions([
                ViewAction::make(),

                Action::make('approve')
                    ->label('Approve')
                    ->color('info')
                    ->icon('heroicon-o-check-circle')
                    ->visible(fn (ReturnRequest $record): bool => $record->status === 'requested')
                    ->schema([
                        Textarea::make('admin_note')
                            ->label('Return instructions for customer')
                            ->placeholder('Explain where or how the customer should return the product.')
                            ->required()
                            ->maxLength(2000),
                    ])
                    ->action(function (ReturnRequest $record, array $data): void {
                        $record->update([
                            'status' => 'approved',
                            'admin_note' => $data['admin_note'],
                            'approved_at' => now(),
                        ]);
                    }),

                Action::make('reject')
                    ->label('Reject')
                    ->color('danger')
                    ->icon('heroicon-o-x-circle')
                    ->requiresConfirmation()
                    ->visible(fn (ReturnRequest $record): bool => $record->status === 'requested')
                    ->schema([
                        Textarea::make('admin_note')
                            ->label('Reason for rejection')
                            ->required()
                            ->maxLength(2000),
                    ])
                    ->action(function (ReturnRequest $record, array $data): void {
                        $record->update([
                            'status' => 'rejected',
                            'admin_note' => $data['admin_note'],
                        ]);
                    }),

                Action::make('mark_received')
                    ->label('Mark Received')
                    ->color('primary')
                    ->icon('heroicon-o-inbox-arrow-down')
                    ->requiresConfirmation()
                    ->modalDescription('This restores the returned quantity to stock. Use it only after TechNova has received and inspected the product.')
                    ->visible(fn (ReturnRequest $record): bool => $record->status === 'approved')
                    ->action(function (ReturnRequest $record): void {
                        DB::transaction(function () use ($record): void {
                            $returnRequest = ReturnRequest::query()
                                ->lockForUpdate()
                                ->findOrFail($record->id);

                            $orderItem = OrderItem::query()
                                ->lockForUpdate()
                                ->findOrFail($returnRequest->order_item_id);

                            if ($orderItem->variant_id) {
                                ProductVariant::query()
                                    ->lockForUpdate()
                                    ->findOrFail($orderItem->variant_id)
                                    ->increment('stock', $returnRequest->quantity);
                            } else {
                                $product = Product::query()
                                    ->lockForUpdate()
                                    ->findOrFail($orderItem->product_id);

                                $product->increaseStock($returnRequest->quantity);
                            }

                            $returnRequest->update([
                                'status' => 'received',
                                'received_at' => now(),
                            ]);
                        });
                    }),

                Action::make('complete_return')
                    ->label('Complete Refund')
                    ->color('success')
                    ->icon('heroicon-o-banknotes')
                    ->requiresConfirmation()
                    ->visible(fn (ReturnRequest $record): bool => $record->status === 'received'
                        && $record->request_type === 'return')
                    ->schema([
                        Textarea::make('admin_note')
                            ->label('Refund details')
                            ->placeholder('Example: Refunded Rs. 2,500 through eSewa on 2026-09-07.')
                            ->required()
                            ->maxLength(2000),
                    ])
                    ->action(function (ReturnRequest $record, array $data): void {
                        $record->update([
                            'status' => 'completed',
                            'admin_note' => $data['admin_note'],
                            'completed_at' => now(),
                        ]);
                    }),

                Action::make('complete_exchange')
                    ->label('Complete Exchange')
                    ->color('success')
                    ->icon('heroicon-o-arrow-path')
                    ->requiresConfirmation()
                    ->visible(fn (ReturnRequest $record): bool => $record->status === 'received'
                        && $record->request_type === 'exchange')
                    ->schema([
                        Textarea::make('admin_note')
                            ->label('Replacement dispatch details')
                            ->placeholder('Example: Replacement shipped through Pathao, tracking number: TN12345.')
                            ->required()
                            ->maxLength(2000),
                    ])
                    ->action(function (ReturnRequest $record, array $data): void {
                        DB::transaction(function () use ($record, $data): void {
                            $returnRequest = ReturnRequest::query()
                                ->lockForUpdate()
                                ->findOrFail($record->id);

                            $exchangeVariant = ProductVariant::query()
                                ->lockForUpdate()
                                ->whereKey($returnRequest->exchange_variant_id)
                                ->where('status', true)
                                ->where('stock', '>=', $returnRequest->quantity)
                                ->firstOrFail();

                            $exchangeVariant->decrement(
                                'stock',
                                $returnRequest->quantity
                            );

                            $returnRequest->update([
                                'status' => 'completed',
                                'admin_note' => $data['admin_note'],
                                'completed_at' => now(),
                            ]);
                        });
                    }),

                EditAction::make(),
            ])
            ->bulkActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                ]),
            ])
            ->defaultSort('created_at', 'desc');
    }
}
