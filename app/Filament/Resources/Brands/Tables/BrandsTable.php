<?php

namespace App\Filament\Resources\Brands\Tables;


use App\Models\Brand;
use Filament\Actions\Action;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Actions\ViewAction;
use Filament\Tables\Columns\ImageColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Columns\ToggleColumn;
use Filament\Tables\Filters\TernaryFilter;
use Filament\Tables\Table;

class BrandsTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('id')
                    ->label('ID')
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),

                ImageColumn::make('logo')
                    ->label('Logo')
                    ->circular()
                    ->width(40)
                    ->height(40)
                    ->toggleable(),

                TextColumn::make('name')
                    ->label('Brand Name')
                    ->searchable()
                    ->sortable()
                    ->weight('bold'),

                TextColumn::make('slug')
                    ->label('Slug')
                    ->searchable()
                    ->toggleable(),

                TextColumn::make('description')
                    ->label('Description')
                    ->limit(50)
                    ->html()
                    ->toggleable(isToggledHiddenByDefault: true),

                ToggleColumn::make('status')
                    ->label('Status')
                    ->sortable(),

                TextColumn::make('products_count')
                    ->label('Products')
                    ->counts('products')
                    ->sortable()
                    ->toggleable(),

                TextColumn::make('created_at')
                    ->label('Created At')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),

                TextColumn::make('updated_at')
                    ->label('Updated At')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                TernaryFilter::make('status')
                    ->label('Status')
                    ->placeholder('All Statuses')
                    ->trueLabel('Active')
                    ->falseLabel('Inactive')
                    ->queries(
                        true: fn ($query) => $query->where('status', true),
                        false: fn ($query) => $query->where('status', false),
                    ),
            ])
            ->actions([
                // View Action - View brand details
                ViewAction::make()
                    ->label('View')
                    ->icon('heroicon-o-eye')
                    ->color('warning')
                    ->tooltip('View Brand Details'),

                //  Edit Action - Edit brand
                EditAction::make()
                    ->label('Edit')
                    ->icon('heroicon-o-pencil')
                    ->color('warning')
                    ->tooltip('Edit Brand'),

                //  Delete Action - Delete single brand
                Action::make('delete')
                    ->label('Delete')
                    ->icon('heroicon-o-trash')
                    ->color('danger')
                    ->tooltip('Delete Brand')
                    ->requiresConfirmation()
                    ->modalHeading('Delete Brand')
                    ->modalDescription('Are you sure you want to delete this brand? This action cannot be undone.')
                    ->modalSubmitActionLabel('Yes, Delete')
                    ->action(fn (Brand $record) => $record->delete()),

                //  Toggle Status Action - Activate/Deactivate brand
                Action::make('toggleStatus')
                    ->label(fn (Brand $record): string => $record->status ? 'Deactivate' : 'Activate')
                    ->icon(fn (Brand $record): string => $record->status ? 'heroicon-o-x-circle' : 'heroicon-o-check-circle')
                    ->color(fn (Brand $record): string => $record->status ? 'danger' : 'success')
                    ->tooltip(fn (Brand $record): string => $record->status ? 'Deactivate Brand' : 'Activate Brand')
                    ->action(function (Brand $record) {
                        $record->update(['status' => !$record->status]);
                    })
                    ->requiresConfirmation()
                    ->modalHeading(fn (Brand $record): string => $record->status ? 'Deactivate Brand' : 'Activate Brand')
                    ->modalDescription(fn (Brand $record): string => $record->status
                        ? 'Are you sure you want to deactivate this brand?'
                        : 'Are you sure you want to activate this brand?'
                    ),

                // View Products Action - View products under this brand
                Action::make('viewProducts')
                    ->label('View Products')
                    ->icon('heroicon-o-shopping-bag')
                    ->color('warning')
                    ->tooltip('View Products under this brand')
                    ->url(fn (Brand $record): string =>
                        route('filament.admin.resources.products.index', [
                            'tableFilters[brand_id][value]' => $record->id
                        ])
                    )
                    ->openUrlInNewTab(),
            ])
            ->bulkActions([
                BulkActionGroup::make([
                    //  Bulk Delete Action
                    DeleteBulkAction::make()
                        ->label('Delete Selected')
                        ->icon('heroicon-o-trash')
                        ->color('danger')
                        ->tooltip('Delete Selected Brands')
                        ->requiresConfirmation()
                        ->modalHeading('Delete Brands')
                        ->modalDescription('Are you sure you want to delete these brands? This action cannot be undone.')
                        ->modalSubmitActionLabel('Yes, Delete'),

                    // ✅ Bulk Status Toggle - Activate/Deactivate multiple brands
                    Action::make('bulkActivate')
                        ->label('Activate Selected')
                        ->icon('heroicon-o-check-circle')
                        ->color('success')
                        ->tooltip('Activate Selected Brands')
                        ->requiresConfirmation()
                        ->modalHeading('Activate Brands')
                        ->modalDescription('Are you sure you want to activate the selected brands?')
                        ->modalSubmitActionLabel('Yes, Activate')
                        ->action(function ($records) {
                            foreach ($records as $record) {
                                $record->update(['status' => true]);
                            }
                        }),

                    Action::make('bulkDeactivate')
                        ->label('Deactivate Selected')
                        ->icon('heroicon-o-x-circle')
                        ->color('danger')
                        ->tooltip('Deactivate Selected Brands')
                        ->requiresConfirmation()
                        ->modalHeading('Deactivate Brands')
                        ->modalDescription('Are you sure you want to deactivate the selected brands?')
                        ->modalSubmitActionLabel('Yes, Deactivate')
                        ->action(function ($records) {
                            foreach ($records as $record) {
                                $record->update(['status' => false]);
                            }
                        }),

                    // ✅ Bulk Export Action
                    Action::make('bulkExport')
                        ->label('Export Selected')
                        ->icon('heroicon-o-arrow-down-tray')
                        ->color('info')
                        ->tooltip('Export Selected Brands')
                        ->action(function ($records) {
                            // Export logic here
                            \Filament\Notifications\Notification::make()
                                ->title('Export started')
                                ->body('Your brands are being exported.')
                                ->success()
                                ->send();
                        }),
                ]),
            ])
            ->defaultSort('name', 'asc')
            ->searchable()
            ->paginated([10, 25, 50, 100])
            ->persistFiltersInSession()
            ->striped()
            ->poll('10s');
    }
}
