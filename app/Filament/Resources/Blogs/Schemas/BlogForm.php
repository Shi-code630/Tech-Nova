<?php

namespace App\Filament\Resources\Blogs\Schemas;

use Filament\Forms\Components\DateTimePicker;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TagsInput;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Forms\Components\RichEditor;
use Filament\Schemas\Components\Grid;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;
use Illuminate\Support\Str;

class BlogForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([

                Section::make('Basic Information')
                    ->schema([
                        TextInput::make('title')
                            ->label('Title')
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

                        Grid::make(2)
                            ->schema([
                                TextInput::make('author')
                                    ->label('Author')
                                    ->maxLength(255),

                                Select::make('category_id')
                                    ->label('Category')
                                    ->relationship('category', 'name')
                                    ->searchable()
                                    ->preload(),
                            ]),
                    ]),

                Section::make('Content')
                    ->schema([
                        Textarea::make('excerpt')
                            ->label('Excerpt')
                            ->rows(3)
                            ->maxLength(500)
                            ->helperText('Optional short summary. Auto-generated from content if left blank.'),

                        RichEditor::make('content')
                            ->label('Content')
                            ->required()
                            ->columnSpanFull(),
                    ]),

                Section::make('Media')
                    ->schema([
                        FileUpload::make('featured_image')
                            ->label('Featured Image')
                            ->image()
                            ->disk('public')
                            ->directory('blogs')
                            ->imagePreviewHeight('200')
                            ->maxSize(5120)
                            ->helperText('Max 5MB. Recommended size: 1200 × 630px'),
                    ]),

                Section::make('Organization')
                    ->schema([
                        TagsInput::make('tags')
                            ->label('Tags')
                            ->helperText('Press Enter to add each tag'),

                        Grid::make(3)
                            ->schema([
                                Toggle::make('is_published')
                                    ->label('Published')
                                    ->default(false)
                                    ->live(),

                                Toggle::make('is_featured')
                                    ->label('Featured')
                                    ->default(false),

                                DateTimePicker::make('published_at')
                                    ->label('Publish Date')
                                    ->native(false)
                                    ->visible(fn ($get) => $get('is_published')),
                            ]),
                    ]),

                Section::make('SEO')
                    ->description('Metadata for search engines')
                    ->collapsible()
                    ->collapsed()
                    ->schema([
                        TextInput::make('meta_title')
                            ->label('Meta Title')
                            ->maxLength(255),

                        Textarea::make('meta_description')
                            ->label('Meta Description')
                            ->rows(3),

                        TextInput::make('meta_keywords')
                            ->label('Meta Keywords')
                            ->maxLength(255),
                    ]),

            ]);
    }
}
