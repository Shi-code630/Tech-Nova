<?php

namespace App\Filament\Resources\Brands\Schemas;

<<<<<<< HEAD
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\Toggle;
use Filament\Forms\Components\FileUpload;
use Filament\Schemas\Schema;
use Illuminate\Validation\Rule;
=======
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\RichEditor;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Components\Grid;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;
use Illuminate\Support\Str;
>>>>>>> 20cda3c69db6227f5f7c3a80902938fab95abb35

class BrandsForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
<<<<<<< HEAD
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

                Textarea::make('description')
                    ->label('Description')
                    ->rows(5)
                    ->nullable(),

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
=======
                Section::make('Basic Information')
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
                                    ->helperText('URL-friendly version of the brand name'),
                            ]),

                        RichEditor::make('description')
                            ->label('Description')
                            ->nullable()
                            ->maxLength(65535)
                            ->toolbarButtons([
                                'bold',
                                'italic',
                                'underline',
                                'strike',
                                'link',
                                'bulletList',
                                'orderedList',
                                'h2',
                                'h3',
                                'blockquote',
                            ])
                            ->columnSpanFull(),
                    ]),

                Section::make('Brand Assets')
                    ->schema([
                        Grid::make(2)
                            ->schema([
                                FileUpload::make('logo')
                                    ->label('Logo')
                                    ->image()
                                    ->directory('brands/logos')
                                    ->maxSize(2048)
                                    ->imageResizeMode('cover')
                                    ->imageCropAspectRatio('1:1')
                                    ->imageResizeTargetWidth('200')
                                    ->imageResizeTargetHeight('200')
                                    ->helperText('Upload a square logo image (max 2MB)'),

                                FileUpload::make('image')
                                    ->label('Brand Image')
                                    ->image()
                                    ->directory('brands/images')
                                    ->maxSize(5120)
                                    ->imageResizeMode('cover')
                                    ->imageCropAspectRatio('16:9')
                                    ->imageResizeTargetWidth('800')
                                    ->imageResizeTargetHeight('450')
                                    ->helperText('Upload a banner image (max 5MB)'),
                            ]),
                    ]),

                Section::make('Status')
                    ->schema([
                        Toggle::make('status')
                            ->label('Active')
                            ->default(true)
                            ->helperText('Enable or disable this brand'),
                    ]),

                Section::make('SEO Information')
                    ->schema([
                        Grid::make(1)
                            ->schema([
                                TextInput::make('meta_title')
                                    ->label('Meta Title')
                                    ->maxLength(255)
                                    ->helperText('Recommended length: 50-60 characters'),

                                TextInput::make('meta_description')
                                    ->label('Meta Description')
                                    ->maxLength(255)
                                    ->helperText('Recommended length: 150-160 characters'),

                                TextInput::make('meta_keywords')
                                    ->label('Meta Keywords')
                                    ->maxLength(255)
                                    ->helperText('Comma-separated keywords'),
                            ]),
                    ]),
>>>>>>> 20cda3c69db6227f5f7c3a80902938fab95abb35
            ]);
    }
}
