<?php

namespace App\Filament\Resources\Reviews\Tables;

use Filament\Actions\Action;
use Filament\Actions\BulkAction;
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

class ReviewsTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('id')
                    ->label('ID')
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),

                TextColumn::make('product.name')
                    ->label('Product')
                    ->searchable()
                    ->sortable()
                    ->weight('bold')
                    ->limit(30),

                TextColumn::make('customer_name')
                    ->label('Customer')
                    ->searchable()
                    ->sortable()
                    ->toggleable(),

                TextColumn::make('rating')
                    ->label('Rating')
                    ->formatStateUsing(function ($state) {
                        $stars = '';
                        for ($i = 0; $i < $state; $i++) {
                            $stars .= '⭐';
                        }
                        return $stars;
                    })
                    ->sortable(),

                TextColumn::make('review')
                    ->label('Review')
                    ->limit(50)
                    ->toggleable()
                    ->tooltip(fn ($record) => $record->review),

                TextColumn::make('status')
                    ->label('Status')
                    ->badge()
                    ->color(fn ($record) => $record->status_badge)
                    ->formatStateUsing(fn ($record) => $record->status_label),

                ToggleColumn::make('status')
                    ->label('Published')
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),

                TextColumn::make('created_at')
                    ->label('Created')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                SelectFilter::make('product_id')
                    ->label('Product')
                    ->relationship('product', 'name')
                    ->searchable()
                    ->preload(),

                SelectFilter::make('rating')
                    ->label('Rating')
                    ->options([
                        1 => '⭐ 1 Star',
                        2 => '⭐⭐ 2 Stars',
                        3 => '⭐⭐⭐ 3 Stars',
                        4 => '⭐⭐⭐⭐ 4 Stars',
                        5 => '⭐⭐⭐⭐⭐ 5 Stars',
                    ]),

                TernaryFilter::make('status')
                    ->label('Status')
                    ->placeholder('All Reviews')
                    ->trueLabel('Published Only')
                    ->falseLabel('Pending Only'),
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
                    ->color('danger')
                    ->icon('heroicon-o-trash')
                    ->requiresConfirmation()
                    ->modalHeading('Delete Review')
                    ->modalDescription('Are you sure you want to delete this review? This action cannot be undone.')
                    ->modalSubmitActionLabel('Yes, Delete'),

                // Quick action to toggle status
                // Action::make('toggle_status')
                //     ->label(fn ($record) => $record->status ? 'Hide' : 'Publish')
                //     ->color(fn ($record) => $record->status ? 'danger' : 'success')
                //     ->icon(fn ($record) => $record->status ? 'heroicon-o-eye-slash' : 'heroicon-o-eye')
                //     ->action(function ($record) {
                //         $record->update(['status' => !$record->status]);
                //     }),
            ])
            ->bulkActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make()
                        ->color('danger')
                        ->icon('heroicon-o-trash'),

                    BulkAction::make('publish')
                        ->label('Publish Selected')
                        ->color('success')
                        ->icon('heroicon-o-check-circle')
                        ->action(function ($records) {
                            $records->each->update(['status' => true]);
                        }),

                    // BulkAction::make('hide')
                    //     ->label('Hide Selected')
                    //     ->color('danger')
                    //     ->icon('heroicon-o-eye-slash')
                    //     ->action(function ($records) {
                    //         $records->each->update(['status' => false]);
                    //     }),
                ]),
            ])
            ->defaultSort('created_at', 'desc')
            ->striped()
            ->paginated([10, 25, 50, 100])
            ->searchable(['review', 'product.name', 'user.name']);
    }
}
