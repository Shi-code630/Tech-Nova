<?php

namespace App\Filament\Resources\DeliveryCharges\Tables;

use App\Models\DeliveryCharge;
use Filament\Actions\Action;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Actions\ViewAction;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

class DeliveryChargesTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('id')
                    ->label('ID')
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),

                TextColumn::make('district')
                    ->label('District')
                    ->searchable()
                    ->sortable(),

                TextColumn::make('charge')
                    ->label('Charge')
                    ->money('NPR')
                    ->sortable(),

                IconColumn::make('status')
                    ->label('Active')
                    ->boolean()
                    ->trueIcon('heroicon-o-check-circle')
                    ->falseIcon('heroicon-o-x-circle')
                    ->trueColor('success')
                    ->falseColor('danger'),

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
                // Add filters if needed
            ])
            ->actions([
                //  View Action - View delivery charge details
                ViewAction::make()
                    ->label('View')
                    ->icon('heroicon-o-eye')
                   ->color('warning')
                    ->tooltip('View Delivery Charge Details'),

                //  Edit Action - Edit delivery charge
                EditAction::make()
                    ->label('Edit')
                    ->icon('heroicon-o-pencil')
                    ->color('warning')
                    ->tooltip('Edit Delivery Charge'),

                // Delete Action - Delete single delivery charge
                Action::make('delete')
                    ->label('Delete')
                    ->icon('heroicon-o-trash')
                    ->color('danger')
                    ->tooltip('Delete Delivery Charge')
                    ->requiresConfirmation()
                    ->modalHeading('Delete Delivery Charge')
                    ->modalDescription('Are you sure you want to delete this delivery charge? This action cannot be undone.')
                    ->modalSubmitActionLabel('Yes, Delete')
                    ->action(fn (DeliveryCharge $record) => $record->delete()),


            ])
            ->bulkActions([
                BulkActionGroup::make([
                    //  Bulk Delete Action
                    DeleteBulkAction::make()
                        ->label('Delete Selected')
                        ->icon('heroicon-o-trash')
                        ->color('danger')
                        ->tooltip('Delete Selected Delivery Charges')
                        ->requiresConfirmation()
                        ->modalHeading('Delete Delivery Charges')
                        ->modalDescription('Are you sure you want to delete these delivery charges? This action cannot be undone.')
                        ->modalSubmitActionLabel('Yes, Delete'),

                    //  Bulk Activate Action
                    Action::make('bulkActivate')
                        ->label('Activate Selected')
                        ->icon('heroicon-o-check-circle')
                        ->color('success')
                        ->tooltip('Activate Selected Delivery Charges')
                        ->requiresConfirmation()
                        ->modalHeading('Activate Delivery Charges')
                        ->modalDescription('Are you sure you want to activate the selected delivery charges?')
                        ->modalSubmitActionLabel('Yes, Activate')
                        ->action(function ($records) {
                            foreach ($records as $record) {
                                $record->update(['status' => true]);
                            }
                            \Filament\Notifications\Notification::make()
                                ->title('Delivery charges activated successfully')
                                ->success()
                                ->send();
                        }),

                    // ✅Bulk Deactivate Action
                    Action::make('bulkDeactivate')
                        ->label('Deactivate Selected')
                        ->icon('heroicon-o-x-circle')
                        ->color('danger')
                        ->tooltip('Deactivate Selected Delivery Charges')
                        ->requiresConfirmation()
                        ->modalHeading('Deactivate Delivery Charges')
                        ->modalDescription('Are you sure you want to deactivate the selected delivery charges?')
                        ->modalSubmitActionLabel('Yes, Deactivate')
                        ->action(function ($records) {
                            foreach ($records as $record) {
                                $record->update(['status' => false]);
                            }
                            \Filament\Notifications\Notification::make()
                                ->title('Delivery charges deactivated successfully')
                                ->success()
                                ->send();
                        }),

                    // Bulk Export Action
                    Action::make('bulkExport')
                        ->label('Export Selected')
                        ->icon('heroicon-o-arrow-down-tray')
                        ->color('info')
                        ->tooltip('Export Selected Delivery Charges')
                        ->action(function ($records) {
                            // Export logic here
                            \Filament\Notifications\Notification::make()
                                ->title('Export started')
                                ->body('Your delivery charges are being exported.')
                                ->success()
                                ->send();
                        }),
                ]),
            ])
            ->defaultSort('district', 'asc')
            ->searchable()
            ->paginated([10, 25, 50, 100])
            ->persistFiltersInSession()
            ->striped();  // ✅ Add striped rows
    }
}
