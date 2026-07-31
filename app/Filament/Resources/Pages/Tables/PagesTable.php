<?php

namespace App\Filament\Resources\Pages\Tables;

use Filament\Actions\Action;
use Filament\Actions\BulkAction;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteAction;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Actions\ViewAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Columns\ToggleColumn;
use Filament\Tables\Filters\TernaryFilter;
use Filament\Tables\Table;

class PagesTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('id')
                    ->label('ID')
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),

                TextColumn::make('title')
                    ->label('Title')
                    ->searchable()
                    ->sortable()
                    ->weight('bold')
                    ->limit(50),

                TextColumn::make('slug')
                    ->label('Slug')
                    ->searchable()
                    ->sortable()
                    ->toggleable()
                    ->copyable()
                    ->copyMessage('Slug copied!'),

                TextColumn::make('excerpt')
                    ->label('Preview')
                    ->limit(60)
                    ->toggleable(),

                TextColumn::make('status')
                    ->label('Status')
                    ->badge()
                    ->color(fn($record) => $record->status_badge)
                    ->formatStateUsing(fn($record) => $record->status_label),

                ToggleColumn::make('status')
                    ->label('Active')
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),

                TextColumn::make('created_at')
                    ->label('Created')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),

                TextColumn::make('updated_at')
                    ->label('Updated')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                TernaryFilter::make('status')
                    ->label('Status')
                    ->placeholder('All Pages')
                    ->trueLabel('Active Only')
                    ->falseLabel('Inactive Only'),
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
                    ->modalHeading('Delete Page')
                    ->modalDescription('Are you sure you want to delete this page? This action cannot be undone.')
                    ->modalSubmitActionLabel('Yes, Delete'),

                Action::make('toggle_status')
                    ->label(fn($record) => $record->status ? 'Deactivate' : 'Activate')
                    ->color(fn($record) => $record->status ? 'secondary' : 'success')
                    ->icon(fn($record) => $record->status ? 'heroicon-o-x-circle' : 'heroicon-o-check-circle')
                    ->button()
                    ->size('sm')
                    ->action(function ($record) {
                        $record->update(['status' => !$record->status]);
                    }),
            ])
            ->bulkActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make()
                        ->color('danger')
                        ->icon('heroicon-o-trash'),

                    BulkAction::make('activate')
                        ->label('Activate Selected')
                        ->color('success')
                        ->icon('heroicon-o-check-circle')
                        ->action(function ($records) {
                            $records->each->update(['status' => true]);
                        }),

                    BulkAction::make('deactivate')
                        ->label('Deactivate Selected')
                        ->color('secondary')
                        ->icon('heroicon-o-x-circle')
                        ->action(function ($records) {
                            $records->each->update(['status' => false]);
                        }),
                ]),
            ])
            ->defaultSort('created_at', 'desc')
            ->striped()
            ->paginated([10, 25, 50, 100])
            ->searchable(['title', 'slug', 'content']);
    }
}
