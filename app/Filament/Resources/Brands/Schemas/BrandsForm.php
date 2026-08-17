<?php

namespace App\Filament\Resources\Brands\Schemas;

use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Components\Grid;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;
use Illuminate\Support\Str;

class BrandsForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([

                Section::make('Basic Information')
                    ->columnSpanFull()
                    ->description('Core details identifying this brand')
                    ->schema([
                        Grid::make(2)
                            ->schema([
                                TextInput::make('name')
                                    ->label('Brand Name')
                                    ->required()
                                    ->maxLength(255)
                                    ->live(onBlur: true)
                                    ->afterStateUpdated(function ($state, callable $set) {
                                        $set('slug', Str::slug($state));
                                    }),

                                TextInput::make('slug')
                                    ->label('Slug')
                                    ->required()
                                    ->maxLength(255)
                                    ->unique(ignoreRecord: true)
                                    ->helperText('Unique URL-friendly identifier.'),
                            ]),
                    ]),

                Section::make('Media')
                    ->collapsed()
                    ->description('Logo and banner image for this brand')
                    ->schema([
                        FileUpload::make('logo')
                            ->label('Logo')
                            ->required()
                            ->image()
                            ->disk('public')
                            ->directory('brands/logos')
                            ->imagePreviewHeight('100')
                            ->maxSize(2048),

                        FileUpload::make('image')
                            ->label('Brand Image')
                            ->required()
                            ->image()
                            ->disk('public')
                            ->directory('brands/images')
                            ->imagePreviewHeight('200')
                            ->maxSize(5120)
                            ->helperText('Upload a banner image (Max 5MB). Recommended size: 1200 × 400px'),
                    ]),

                Section::make('SEO')
                    ->description('Metadata for search engines')
                    ->collapsible()
                    ->collapsed()
                    ->schema([
                        TextInput::make('meta_title')
                            ->label('Meta Title')
                            ->required()
                            ->maxLength(255),

                        TextInput::make('meta_keywords')
                            ->label('Meta Keywords')
                            ->required()
                            ->maxLength(255),
                        Textarea::make('meta_description')
                            ->label('Meta Description')
                            ->required()
                            ->rows(3),


                    ]),

                Section::make('Status')
                    ->schema([
                        Toggle::make('status')
                            ->label('Active')
                            ->default(true)
                            ->inline(false),
                    ]),

            ]);
    }
}
