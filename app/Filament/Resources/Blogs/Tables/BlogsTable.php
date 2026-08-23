<?php

namespace App\Filament\Resources\Blogs\Tables;

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

class BlogsTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                ImageColumn::make('featured_image')
                    ->label('Image')
                    ->square()
                    ->size(50),

                TextColumn::make('title')
                    ->label('Title')
                    ->searchable()
                    ->sortable()
                    ->limit(40)
                    ->weight('semibold'),

                TextColumn::make('category.name')
                    ->label('Category')
                    ->badge()
                    ->sortable(),

                TextColumn::make('author')
                    ->label('Author')
                    ->searchable(),

                TextColumn::make('views')
                    ->label('Views')
                    ->formatStateUsing(fn($state) => $state >= 1000 ? number_format($state / 1000, 1) . 'K' : number_format($state))
                    ->sortable(),

                ToggleColumn::make('is_published')
                    ->label('Published'),

                ToggleColumn::make('is_featured')
                    ->label('Featured'),

                TextColumn::make('published_at')
                    ->label('Published At')
                    ->dateTime('d M, Y')
                    ->sortable()
                    ->placeholder('Not published'),

                TextColumn::make('created_at')
                    ->label('Created')
                    ->dateTime('d M, Y')
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                SelectFilter::make('category_id')
                    ->label('Category')
                    ->relationship('category', 'name')
                    ->preload()
                    ->searchable(),

                TernaryFilter::make('is_published')
                    ->label('Published Status')
                    ->placeholder('All Blogs')
                    ->trueLabel('Published Only')
                    ->falseLabel('Unpublished Only'),

                TernaryFilter::make('is_featured')
                    ->label('Featured Status')
                    ->placeholder('All Blogs')
                    ->trueLabel('Featured Only')
                    ->falseLabel('Not Featured'),
            ])
            ->recordActions([
                EditAction::make(),
                DeleteAction::make()
                    ->requiresConfirmation(),
                ViewAction::make()
                    ->color('danger'),

            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                ]),
            ])
            ->defaultSort('created_at', 'desc');
    }
}
