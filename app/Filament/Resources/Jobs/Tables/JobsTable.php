<?php

namespace App\Filament\Resources\Jobs\Tables;

use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteAction;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Actions\ViewAction;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Filters\TernaryFilter;
use Filament\Tables\Table;

class JobsTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('title')
                    ->label('Job Title')
                    ->searchable()
                    ->sortable(),

                TextColumn::make('department')
                    ->label('Department')
                    ->badge()
                    ->color('info')
                    ->sortable(),

                TextColumn::make('location')
                    ->label('Location')
                    ->searchable()
                    ->sortable(),

                TextColumn::make('type')
                    ->label('Job Type')
                    ->badge()
                    ->sortable(),

                TextColumn::make('experience')
                    ->label('Experience')
                    ->searchable(),

                TextColumn::make('posted')
                    ->label('Posted'),

                IconColumn::make('is_published')
                    ->label('Published')
                    ->boolean(),

                TextColumn::make('created_at')
                    ->label('Created')
                    ->dateTime('d M Y')
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),

                TextColumn::make('updated_at')
                    ->label('Updated')
                    ->dateTime('d M Y')
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])

            ->filters([
                SelectFilter::make('department')
                    ->label('Department')
                    ->options([
                        'Engineering' => 'Engineering',
                        'Marketing'   => 'Marketing',
                        'Design'      => 'Design',
                        'Support'     => 'Support',
                        'Product'     => 'Product',
                    ]),

                TernaryFilter::make('is_published')
                    ->label('Published'),
            ])

            ->recordActions([
                EditAction::make(),
                ViewAction::make()
                    ->label('View')
                    ->color('warning')
                    ->icon('heroicon-o-eye'),
                DeleteAction::make(),


            ])

            ->toolbarActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                ]),
            ])

            ->defaultSort('created_at', 'desc');
    }
}
