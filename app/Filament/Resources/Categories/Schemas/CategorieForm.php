<?php

namespace App\Filament\Resources\Categories\Schemas;  // ✅ Correct namespace

use App\Models\Categorie;
use App\Models\Category;
use Filament\Forms\Components\RichEditor;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Components\Grid;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;
use Illuminate\Support\Str;

class CategorieForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make('Basic Information')
                    ->schema([
                        Grid::make(2)
                            ->schema([
                                Select::make('parent_id')
                                    ->label('Parent Category')
                                    ->options(Category::query()->pluck('name', 'id'))
                                    ->searchable()
                                    ->preload()
                                    ->nullable()
                                    ->helperText('Select a parent category if this is a subcategory'),

                                TextInput::make('name')
                                    ->label('Category Name')
                                    ->required()
                                    ->maxLength(255)
                                    ->live(onBlur: true)
                                    ->afterStateUpdated(function ($state, callable $set) {
                                        $set('slug', Str::slug($state));
                                    }),
                            ]),

                        TextInput::make('slug')
                            ->label('Slug')
                            ->required()
                            ->maxLength(255)
                            ->unique(ignoreRecord: true)
                            ->helperText('URL-friendly version of the category name'),

                        RichEditor::make('description')
                            ->label('Description')
                            ->required()
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

                Section::make('Status')
                    ->schema([
                        Toggle::make('status')
                            ->label('Active')
                            ->default(true)
                            ->helperText('Enable or disable this category'),
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
            ]);
    }
}
