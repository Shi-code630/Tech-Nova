<?php

namespace App\Filament\Resources\Brands\Schemas;

use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\Toggle;
use Filament\Forms\Components\FileUpload;
use Filament\Schemas\Schema;
use Illuminate\Validation\Rule;

class BrandsForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('name')
                    ->label('Brand Name')
                    ->required()
                    ->maxLength(255)
                    ->live(onBlur: true)
                    ->afterStateUpdated(function ($state, callable $set) {
                        // Auto-generate slug from name
                        $set('slug', \Illuminate\Support\Str::slug($state));
                    }),

                TextInput::make('slug')
                    ->label('Slug')
                    ->required()
                    ->maxLength(255)
                    ->unique(ignoreRecord: true)
                    ->helperText('Unique URL-friendly identifier. Leave blank to auto-generate.'),

                FileUpload::make('logo')
                    ->label('Logo')
                    ->image()
                    ->imagePreviewHeight('100')
                    ->directory('brands/logos')
                    ->disk('public')
                    ->maxSize(2048) // 2MB
                    ->nullable(),

                FileUpload::make('image')
                    ->label('Brand Image')
                    ->image()
                    ->imagePreviewHeight('200')
                    ->directory('brands/images')
                    ->disk('public')
                    ->maxSize(2048)
                    ->nullable(),

                                FileUpload::make('image')
                                    ->label('Brand Image')
                                    ->image()
                                    ->directory('brands')
                                    ->maxSize(5120) // 5MB
                                    ->helperText('Upload a banner image (max 5MB). Recommended size: 1200x400px'),
                            ]),
                    ]),

                Toggle::make('status')
                    ->label('Active')
                    ->default(true)
                    ->inline(false),

                TextInput::make('meta_title')
                    ->label('Meta Title')
                    ->maxLength(255)
                    ->nullable(),

                Textarea::make('meta_description')
                    ->label('Meta Description')
                    ->rows(3)
                    ->nullable(),

                TextInput::make('meta_keywords')
                    ->label('Meta Keywords')
                    ->maxLength(255)
                    ->nullable(),
            ]);
    }
}
