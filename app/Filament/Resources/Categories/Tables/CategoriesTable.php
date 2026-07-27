<?php

namespace App\Filament\Resources\Categories\Tables;

<<<<<<< HEAD
use App\Models\Categorie;
=======
use App\Filament\Resources\Categories\CategoriesResource;
use App\Models\Categorie;
use Filament\Actions\Action;
>>>>>>> 20cda3c69db6227f5f7c3a80902938fab95abb35
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteAction;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Tables\Columns\TextColumn;
<<<<<<< HEAD
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\BadgeColumn;
=======
use Filament\Tables\Columns\ToggleColumn;
>>>>>>> 20cda3c69db6227f5f7c3a80902938fab95abb35
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
<<<<<<< HEAD
                    ->label('Name')
                    ->searchable()
                    ->sortable()
                    ->limit(30),

                TextColumn::make('parents.name')
                    ->label('Parent')
                    ->searchable()
                    ->sortable()
                    ->placeholder('None'),
=======
                    ->label('Category Name')
                    ->searchable()
                    ->sortable()
                    ->weight('bold'),

                TextColumn::make('parent.name')
                    ->label('Parent Category')
                    ->searchable()
                    ->sortable()
                    ->placeholder('Root Category')
                    ->badge()
                    ->color('gray'),
>>>>>>> 20cda3c69db6227f5f7c3a80902938fab95abb35

                TextColumn::make('slug')
                    ->label('Slug')
                    ->searchable()
                    ->toggleable(),

<<<<<<< HEAD
                IconColumn::make('status')
                    ->label('Active')
                    ->boolean()
                    ->sortable(),

                TextColumn::make('created_at')
                    ->label('Created')
=======
                TextColumn::make('description')
                    ->label('Description')
                    ->limit(50)
                    ->html()
                    ->toggleable(isToggledHiddenByDefault: true),

                ToggleColumn::make('status')
                    ->label('Status')
                    ->sortable(),

                TextColumn::make('children_count')
                    ->label('Subcategories')
                    ->counts('children')
                    ->sortable()
                    ->toggleable(),

                TextColumn::make('created_at')
                    ->label('Created At')
>>>>>>> 20cda3c69db6227f5f7c3a80902938fab95abb35
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),

                TextColumn::make('updated_at')
<<<<<<< HEAD
                    ->label('Updated')
=======
                    ->label('Updated At')
>>>>>>> 20cda3c69db6227f5f7c3a80902938fab95abb35
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
<<<<<<< HEAD
                TernaryFilter::make('status')
                    ->label('Active')
                    ->boolean()
                    ->trueLabel('Active only')
                    ->falseLabel('Inactive only')
                    ->native(false),

                SelectFilter::make('parent_id')
                    ->label('Parent Category')
                    ->options(fn () => Categorie::pluck('name', 'id')->toArray())
                    ->searchable(),
=======
                SelectFilter::make('parent_id')
                    ->label('Parent Category')
                    ->options(Categorie::query()->pluck('name', 'id'))
                    ->searchable()
                    ->preload()
                    ->placeholder('All Categories'),

                TernaryFilter::make('status')
                    ->label('Status')
                    ->placeholder('All Statuses')
                    ->trueLabel('Active')
                    ->falseLabel('Inactive')
                    ->queries(
                        true: fn($query) => $query->where('status', true),
                        false: fn($query) => $query->where('status', false),
                    ),
>>>>>>> 20cda3c69db6227f5f7c3a80902938fab95abb35
            ])
            ->actions([
                EditAction::make()
                    ->icon('heroicon-o-pencil')
                    ->tooltip('Edit Category'),


                DeleteAction::make()
                    ->icon('heroicon-o-trash')
                    ->tooltip('Delete User')
                    ->color('danger')
                    ->requiresConfirmation()
                    ->modalHeading('Delete User')
                    ->modalDescription('Are you sure you want to delete this user? This action cannot be undone.')
                    ->modalSubmitActionLabel('Delete')
                    ->successNotificationTitle('categories deleted successfully'),
                Action::make('view')
                    ->label('View Subcategories')
                    ->icon('heroicon-o-squares-2x2')
                    ->url(
                        fn(Categorie $record): string =>
                        CategoriesResource::getUrl('index', ['tableFilters[parent_id][value]' => $record->id])
                    )
                    ->openUrlInNewTab()
                    ->tooltip('View subcategories'),
                    
            ])
            ->bulkActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make()
                        ->icon('heroicon-o-trash')
                        ->tooltip('Delete Selected')
                        ->requiresConfirmation()
                        ->modalHeading('Delete Categories')
                        ->modalDescription('Are you sure you want to delete these categories? This action cannot be undone.')
                        ->modalSubmitActionLabel('Yes, Delete'),
                ]),
            ])
<<<<<<< HEAD
            ->defaultSort('name', 'asc');
=======
            ->defaultSort('name', 'asc')
            ->searchable()
            ->paginated([10, 25, 50, 100])
            ->persistFiltersInSession();
>>>>>>> 20cda3c69db6227f5f7c3a80902938fab95abb35
    }
}
