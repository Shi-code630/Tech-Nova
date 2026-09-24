<?php

namespace App\Filament\Resources\Banners\Tables;

use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteAction;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Actions\ViewAction;
use Filament\Tables\Columns\ImageColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Columns\ToggleColumn;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Filters\TernaryFilter;
use Filament\Tables\Table;

class BannerTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                ImageColumn::make('image')
                    ->label('Image')
                    ->disk('public')
                    ->square()
                    ->size(60)
                    ->defaultImageUrl(fn ($record) => $record->image ? asset('storage/' . $record->image) : null),

                TextColumn::make('type')
                    ->label('Type')
                    ->badge()
                    ->color(fn (string $state) => $state === 'main' ? 'primary' : 'gray')
                    ->formatStateUsing(fn (string $state) => $state === 'main' ? 'Main' : 'Small')
                    ->sortable(),

                TextColumn::make('title')
                    ->label('Title')
                    ->searchable()
                    ->sortable()
                    ->weight('bold'),

                TextColumn::make('subtitle')
                    ->label('Subtitle')
                    ->searchable()
                    ->toggleable(isToggledHiddenByDefault: true),

                TextColumn::make('button_text')
                    ->label('Button')
                    ->searchable()
                    ->toggleable(isToggledHiddenByDefault: true),

                TextColumn::make('position')
                    ->label('Position')
                    ->badge()
                    ->formatStateUsing(fn ($state) => match ((int) $state) {
                        1 => 'Left',
                        2 => 'Center',
                        3 => 'Right',
                        default => '—',
                    })
                    ->color(fn ($state) => match ((int) $state) {
                        1 => 'info',
                        2 => 'primary',
                        3 => 'warning',
                        default => 'gray',
                    })
                    ->sortable()
                    ->toggleable(),

                TextColumn::make('sort_order')
                    ->label('Order')
                    ->sortable()
                    ->toggleable(),

                ToggleColumn::make('status')
                    ->label('Active')
                    ->sortable(),

                TextColumn::make('status_label')
                    ->label('Status')
                    ->badge()
                    ->color(fn ($record) => $record->status_badge)
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
            ->defaultSort('sort_order', 'asc')
            ->filters([
                SelectFilter::make('type')
                    ->label('Banner Type')
                    ->options([
                        'main' => 'Main',
                        'small' => 'Small',
                    ]),

                SelectFilter::make('position')
                    ->label('Position')
                    ->options([
                        1 => 'Left',
                        2 => 'Center',
                        3 => 'Right',
                    ]),

                TernaryFilter::make('status')
                    ->label('Active Status')
                    ->placeholder('All Banners')
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
                    ->icon('heroicon-o-trash')
                    ->color('warning')
                    ->requiresConfirmation()
                    ->modalHeading('Delete Banner')
                    ->modalDescription('Are you sure you want to delete this banner? This action cannot be undone.')
                    ->modalSubmitActionLabel('Yes, Delete'),
            ])
            ->bulkActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make()
                        ->label('Delete Selected')
                        ->color('danger')
                        ->icon('heroicon-o-trash')
                        ->requiresConfirmation()
                        ->modalHeading('Delete Selected Banners')
                        ->modalDescription('Are you sure you want to delete the selected banners? This action cannot be undone.'),
                ]),
            ])
            ->striped()
            ->paginated([10, 25, 50, 100])
            ->searchable();
    }
}
