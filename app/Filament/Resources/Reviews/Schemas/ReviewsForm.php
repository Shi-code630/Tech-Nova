<?php

namespace App\Filament\Resources\Reviews\Schemas;

use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;

use Filament\Forms\Components\Toggle;
use Filament\Schemas\Components\Grid;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;

class ReviewsForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make('Review Information')
                    ->schema([
                        Grid::make(2)
                            ->schema([
                                Select::make('product_id')
                                    ->label('Product')
                                    ->relationship('product', 'name')
                                    ->searchable()
                                    ->preload()
                                    ->required(),

                                Select::make('user_id')
                                    ->label('Customer')
                                    ->relationship('user', 'name')
                                    ->searchable()
                                    ->preload()
                                    ->nullable()
                                    ->helperText('Select customer (optional)'),

                                Select::make('rating')
                                    ->label('Rating')
                                    ->options([
                                        1 => '⭐ 1 Star',
                                        2 => '⭐⭐ 2 Stars',
                                        3 => '⭐⭐⭐ 3 Stars',
                                        4 => '⭐⭐⭐⭐ 4 Stars',
                                        5 => '⭐⭐⭐⭐⭐ 5 Stars',
                                    ])
                                    ->default(5)
                                    ->required(),

                                Textarea::make('review')
                                    ->label('Review Comment')
                                    ->rows(4)
                                    ->nullable()
                                    ->placeholder('Write the review here...'),

                                Toggle::make('status')
                                    ->label('Published')
                                    ->default(true)
                                    ->helperText('Show this review on the site'),
                            ]),
                    ]),
            ]);
    }
}
