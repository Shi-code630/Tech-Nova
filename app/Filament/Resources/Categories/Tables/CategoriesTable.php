<?php

namespace App\Filament\Resources\Categories\Tables;

use App\Filament\Resources\Categories\CategoriesResource;
use App\Models\Category;
use Filament\Actions\Action;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteAction;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Filters\TernaryFilter;
use Filament\Tables\Table;

class CategoriesTable
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
                    ->limit(30)
                    ->description(
                        fn (Category $record) =>
                            $record->parent
                                ? 'Parent: ' . $record->parent->name
                                : 'Top Level'
                    ),

                TextColumn::make('parent.name')
                    ->label('Parent Category')
                    ->searchable()
                    ->sortable()
                    ->placeholder('None')
                    ->badge()
                    ->color('gray'),

                TextColumn::make('children_count')
                    ->label('Subcategories')
                    ->counts('children')
                    ->badge()
                    ->color('info')
                    ->sortable(),

                TextColumn::make('slug')
                    ->label('Slug')
                    ->searchable()
                    ->toggleable(),

                IconColumn::make('status')
                    ->label('Active')
                    ->boolean()
                    ->sortable()
                    ->trueIcon('heroicon-o-check-circle')
                    ->falseIcon('heroicon-o-x-circle')
                    ->trueColor('success')
                    ->falseColor('danger'),

                TextColumn::make('created_at')
                    ->label('Created')
                    ->dateTime('d M, Y')
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),

                TextColumn::make('updated_at')
                    ->label('Updated')
                    ->dateTime('d M, Y')
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])

            ->filters([
                TernaryFilter::make('status')
                    ->label('Status')
                    ->placeholder('All Statuses')
                    ->trueLabel('Active Only')
                    ->falseLabel('Inactive Only')
                    ->queries(
                        true: fn ($query) => $query->where('status', true),
                        false: fn ($query) => $query->where('status', false),
                    ),

                SelectFilter::make('parent_id')
                    ->label('Parent Category')
                    ->options(
                        Category::query()
                            ->orderBy('name')
                            ->pluck('name', 'id')
                    )
                    ->searchable()
                    ->preload()
                    ->placeholder('All Categories'),
            ])

            ->recordActions([
                EditAction::make()
                    ->label('Edit')
                    ->icon('heroicon-o-pencil-square')
                    ->color('warning'),

                Action::make('view_subcategories')
                    ->label('Subcategories')
                    ->icon('heroicon-o-squares-2x2')
                    ->url(
                        fn (Category $record): string =>
                            CategoriesResource::getUrl(
                                'index',
                                [
                                    'tableFilters[parent_id][value]' => $record->id,
                                ]
                            )
                    )
                    ->openUrlInNewTab()
                    ->tooltip('View subcategories'),

                DeleteAction::make()
                    ->label('Delete')
                    ->icon('heroicon-o-trash')
                    ->color('danger')
                    ->requiresConfirmation()
                    ->modalHeading('Delete Category')
                    ->modalDescription(
                        'Are you sure you want to delete this category? This action cannot be undone.'
                    )
                    ->modalSubmitActionLabel('Delete')
                    ->successNotificationTitle(
                        'Category deleted successfully'
                    ),
            ])

            ->toolbarActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make()
                        ->label('Delete Selected')
                        ->icon('heroicon-o-trash')
                        ->color('danger'),
                ]),
            ])

            ->defaultSort('name', 'asc')

            ->emptyStateHeading('No categories found')
            ->emptyStateDescription(
                'Create your first category by clicking the "New Category" button.'
            )
            ->emptyStateIcon('heroicon-o-tag');
    }
}
