<?php

namespace App\Filament\Resources\Products\RelationManagers;

use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Schemas\Components\Grid;
use Filament\Schemas\Schema;
use Filament\Tables\Columns\ImageColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Columns\ToggleColumn;
use Filament\Tables\Table;
use Filament\Actions\CreateAction;
use Filament\Actions\EditAction;
use Filament\Actions\DeleteAction;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;

class VariantsRelationManager extends RelationManager
{
    protected static string $relationship = 'variants';

    protected static ?string $title = 'Variants';

    public function form(Schema $schema): Schema
    {
        return $schema
            ->components([
                Grid::make(3)
                    ->schema([
                        TextInput::make('color')
                            ->label('Color')
                            ->placeholder('e.g. Red, Blue, Black')
                            ->maxLength(255),

                        TextInput::make('size')
                            ->label('Size')
                            ->placeholder('e.g. S, M, L, XL')
                            ->maxLength(255),

                        TextInput::make('price')
                            ->label('Price (Rs.)')
                            ->numeric()
                            ->required()
                            ->prefix('Rs.')
                            ->step(0.01)
                            ->minValue(0),

                        TextInput::make('stock')
                            ->label('Stock Quantity')
                            ->numeric()
                            ->required()
                            ->default(0)
                            ->minValue(0)
                            ->integer(),

                        Toggle::make('status')
                            ->label('Active')
                            ->default(true),

                        FileUpload::make('image')
                            ->label('Variant Image')
                            ->image()
                            ->directory('product-variants')
                            ->imageResizeTargetWidth('500')
                            ->imageResizeTargetHeight('500')
                            ->columnSpanFull(),
                    ]),
            ]);
    }

    public function table(Table $table): Table
    {
        return $table
            ->recordTitleAttribute('full_name')
            ->columns([
                ImageColumn::make('image')
                    ->label('Image')
                    ->square()
                    ->size(50),

                TextColumn::make('color')
                    ->label('Color')
                    ->searchable(),

                TextColumn::make('size')
                    ->label('Size')
                    ->searchable(),

                TextColumn::make('price')
                    ->label('Price')
                    ->money('Rs.')
                    ->sortable(),

                TextColumn::make('stock')
                    ->label('Stock')
                    ->numeric()
                    ->sortable()
                    ->color(fn ($record) => $record->stock > 10 ? 'success' : ($record->stock > 0 ? 'warning' : 'danger')),

                TextColumn::make('stock_status')
                    ->label('Status')
                    ->badge()
                    ->color(fn ($record) => $record->stock_status_color),

                ToggleColumn::make('status')
                    ->label('Active'),
            ])
            ->headerActions([
                CreateAction::make(),
            ])
            ->recordActions([
                EditAction::make(),
                DeleteAction::make()->requiresConfirmation(),
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                ]),
            ])
            ->defaultSort('created_at', 'desc');
    }
}
