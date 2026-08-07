<?php

namespace App\Filament\Resources\Settings\Tables;

use Filament\Actions\BulkAction;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteAction;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Actions\ViewAction;
use Filament\Notifications\Notification;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\ImageColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

class SettingsTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                ImageColumn::make('logo')
                    ->label('Logo')
                    ->square()
                    ->size(50)
                    ->defaultImageUrl(fn($record) => $record->logo_url ?? null),

                TextColumn::make('site_name')
                    ->label('Store Name')
                    ->searchable()
                    ->sortable()
                    ->weight('bold')
                    ->color('primary'),

                TextColumn::make('email')
                    ->label('Email')
                    ->searchable()
                    ->sortable()
                    ->copyable()
                    ->copyMessage('Email copied!')
                    ->icon('heroicon-o-envelope'),

                TextColumn::make('phone')
                    ->label('Phone')
                    ->searchable()
                    ->sortable()
                    ->icon('heroicon-o-phone'),

                TextColumn::make('currency')
                    ->label('Currency')
                    ->badge()
                    ->color('primary')
                    ->formatStateUsing(fn($state) => $state ?? 'NPR')
                    ->toggleable(isToggledHiddenByDefault: true),

                IconColumn::make('maintenance_mode')
                    ->label('Maintenance')
                    ->boolean()
                    ->trueIcon('heroicon-o-shield-exclamation')
                    ->falseIcon('heroicon-o-check-circle')
                    ->trueColor('danger')
                    ->falseColor('success')
                    ->tooltip(fn($record) => $record->maintenance_mode ? 'Maintenance mode is ON' : 'Maintenance mode is OFF')
                    ->toggleable(isToggledHiddenByDefault: true),

                TextColumn::make('updated_at')
                    ->label('Last Updated')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
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
                    ->modalHeading('Delete Settings')
                    ->modalDescription('Are you sure you want to delete these settings? This action cannot be undone.')
                    ->modalSubmitActionLabel('Yes, Delete'),
            ])
            ->bulkActions([
                BulkActionGroup::make([

                    DeleteBulkAction::make()
                        ->label('Delete Selected')
                        ->color('danger')
                        ->icon('heroicon-o-trash')
                        ->requiresConfirmation()
                        ->modalHeading('Delete Selected Settings')
                        ->modalDescription('Are you sure you want to delete the selected settings? This action cannot be undone.')
                        ->modalSubmitActionLabel('Yes, Delete'),

                    //  Enable Maintenance Mode Bulk Action
                    BulkAction::make('enable_maintenance')
                        ->label('Enable Maintenance')
                        ->color('danger')
                        ->icon('heroicon-o-shield-exclamation')
                        ->requiresConfirmation()
                        ->action(function ($records) {
                            $records->each->update(['maintenance_mode' => true]);
                            Notification::make()
                                ->title('Maintenance mode enabled')
                                ->body('All selected settings have maintenance mode enabled.')
                                ->success()
                                ->send();
                        })
                        ->deselectRecordsAfterCompletion(),

                    // Disable Maintenance Mode Bulk Action
                    BulkAction::make('disable_maintenance')
                        ->label('Disable Maintenance')
                        ->color('success')
                        ->icon('heroicon-o-check-circle')
                        ->requiresConfirmation()
                        ->action(function ($records) {
                            $records->each->update(['maintenance_mode' => false]);
                            Notification::make()
                                ->title('Maintenance mode disabled')
                                ->body('All selected settings have maintenance mode disabled.')
                                ->success()
                                ->send();
                        })
                        ->deselectRecordsAfterCompletion(),
                ]),
            ])
            ->defaultSort('created_at', 'desc')
            ->paginated(false) // Disable pagination since there's usually only one settings record
            ->striped()
            ->searchable();
    }
}
