<?php

namespace App\Filament\Resources\ContactMessages\Tables;

use Filament\Actions\Action;
use Filament\Actions\BulkAction;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteAction;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Actions\ViewAction;
use Filament\Forms\Components\DatePicker;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Columns\ToggleColumn;
use Filament\Tables\Filters\Filter;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Filters\TernaryFilter;
use Filament\Tables\Table;

class ContactMessagesTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('id')
                    ->label('ID')
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),

                TextColumn::make('name')
                    ->label('Name')
                    ->searchable()
                    ->sortable()
                    ->weight('bold')
                    ->icon('heroicon-o-user'),

                TextColumn::make('email')
                    ->label('Email')
                    ->searchable()
                    ->sortable()
                    ->icon('heroicon-o-envelope')
                    ->copyable()
                    ->copyMessage('Email copied!'),

                TextColumn::make('subject')
                    ->label('Subject')
                    ->searchable()
                    ->sortable()
                    ->limit(30),

                TextColumn::make('message_excerpt')
                    ->label('Message')
                    ->limit(50)
                    ->toggleable()
                    ->tooltip(fn($record) => $record->message),

                TextColumn::make('phone')
                    ->label('Phone')
                    ->searchable()
                    ->toggleable(isToggledHiddenByDefault: true),

                TextColumn::make('status')
                    ->label('Status')
                    ->badge()
                    ->color(fn($record) => $record->status_badge)
                    ->formatStateUsing(fn($record) => $record->status_label)
                    ->icon(fn($record) => $record->status ? 'heroicon-o-check-circle' : 'heroicon-o-clock'),

                ToggleColumn::make('status')
                    ->label('Read')
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),

                TextColumn::make('formatted_date')
                    ->label('Received')
                    ->sortable()
                    ->toggleable(),
            ])
            ->filters([
                TernaryFilter::make('status')
                    ->label('Status')
                    ->placeholder('All Messages')
                    ->trueLabel('Read Only')
                    ->falseLabel('Unread Only'),

                SelectFilter::make('subject')
                    ->label('Subject')
                    ->options(function () {
                        return \App\Models\ContactMessage::distinct('subject')
                            ->pluck('subject', 'subject')
                            ->filter()
                            ->toArray();
                    })
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
                            ->when($data['created_from'], fn($q) => $q->whereDate('created_at', '>=', $data['created_from']))
                            ->when($data['created_until'], fn($q) => $q->whereDate('created_at', '<=', $data['created_until']));
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
                    ->icon('heroicon-o-pencil-square'),

                DeleteAction::make()
                    ->label('Delete')
                    ->color('danger')
                    ->icon('heroicon-o-trash')

                    ->requiresConfirmation()
                    ->modalHeading('Delete Message')
                    ->modalDescription('Are you sure you want to delete this message? This action cannot be undone.')
                    ->modalSubmitActionLabel('Yes, Delete'),

                //  Quick action to mark as read/unread
                Action::make('toggle_status')
                    ->label(fn($record) => $record->status ? 'Mark Unread' : 'Mark Read')
                    ->color(fn($record) => $record->status ? 'secondary' : 'success')
                    ->icon(fn($record) => $record->status ? 'heroicon-o-clock' : 'heroicon-o-check-circle')

                    ->action(function ($record) {
                        $record->update(['status' => !$record->status]);
                    }),
            ])
            ->bulkActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make()
                        ->label('Delete Selected')
                        ->color('warning')
                        ->icon('heroicon-o-trash')
                        ->requiresConfirmation()
                        ->modalHeading('Delete Selected Messages')
                        ->modalDescription('Are you sure you want to delete the selected messages? This action cannot be undone.'),


                    BulkAction::make('mark_read')
                        ->label('Mark as Read')
                        ->color('success')
                        ->icon('heroicon-o-check-circle')
                        ->action(function ($records) {
                            $records->each->update(['status' => true]);
                        }),

                    BulkAction::make('mark_unread')
                        ->label('Mark as Unread')
                        ->color('warning')
                        ->icon('heroicon-o-clock')
                        ->action(function ($records) {
                            $records->each->update(['status' => false]);
                        }),
                ]),
            ])
            ->defaultSort('created_at', 'desc')
            ->striped()
            ->paginated([10, 25, 50, 100])
            ->searchable(['name', 'email', 'subject', 'message', 'phone']);
    }
}
