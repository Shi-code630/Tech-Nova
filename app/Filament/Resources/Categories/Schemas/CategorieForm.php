<?php

namespace App\Filament\Resources\Categories\Schemas;

use App\Models\Category;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Components\Grid;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;

class CategorieForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make('Basic Information')
                    ->columnSpanFull()
                    ->description('Enter the basic details of the category.')
                    ->schema([
                        Grid::make(2)
                            ->schema([
                                TextInput::make('name')
                                    ->label('Category Name')
                                    ->required()
                                    ->maxLength(255)
                                    ->live(onBlur: true)
                                    ->afterStateUpdated(
                                        function ($state, callable $set): void {
                                            $set('slug', Str::slug($state));
                                        }
                                    )
                                    ->placeholder('e.g. Mobile & Tablets'),

                                TextInput::make('slug')
                                    ->label('Slug')
                                    ->required()
                                    ->maxLength(255)
                                    ->unique(ignoreRecord: true)
                                    ->placeholder('e.g. mobile-tablets')
                                    ->helperText(
                                        'URL-friendly identifier. Automatically generated from the category name.'
                                    ),

                                Select::make('parent_id')
                                    ->label('Parent Category')
                                    ->options(
                                        fn($record): array =>
                                        static::getParentOptions($record)
                                    )
                                    ->searchable()
                                    ->preload()
                                    ->nullable()
                                    ->placeholder('Select parent category (optional)')
                                    ->helperText(
                                        'Leave empty to create a top-level category.'
                                    )
                                    ->rule(
                                        function ($record) {
                                            $excludedIds = [];

                                            if ($record) {
                                                $excludedIds = array_merge(
                                                    [$record->id],
                                                    static::getDescendantIds($record)
                                                );
                                            }

                                            return Rule::notIn($excludedIds);
                                        }
                                    )
                                    ->validationMessages([
                                        'not_in' =>
                                        'You cannot select this category or one of its children as the parent.',
                                    ]),

                                Toggle::make('status')
                                    ->label('Active')
                                    ->default(true)
                                    ->helperText(
                                        'Enable or disable this category.'
                                    ),
                            ]),

                        Textarea::make('description')
                            ->label('Description')
                            ->rows(5)
                            ->maxLength(5000)
                            ->placeholder('Enter category description...')
                            ->columnSpanFull(),
                    ]),

                Section::make('SEO')
                    ->columnSpanFull()
                    ->description('Optional search engine optimization information.')
                    ->collapsed()
                    ->schema([
                        TextInput::make('meta_title')
                            ->label('Meta Title')
                            ->maxLength(255)
                            ->placeholder('SEO title for search engines'),



                        TextInput::make('meta_keywords')
                            ->label('Meta Keywords')
                            ->maxLength(255)
                            ->placeholder(
                                'Comma separated keywords'
                            ),
                        Textarea::make('meta_description')
                            ->label('Meta Description')
                            ->rows(3)
                            ->maxLength(500)
                            ->placeholder(
                                'SEO description for search engines'
                            ),
                    ]),
            ]);
    }

    /**
     * Get parent category options with hierarchy.
     */
    private static function getParentOptions($record = null): array
    {
        $excludeIds = [];

        if ($record) {
            $excludeIds = array_merge(
                [$record->id],
                static::getDescendantIds($record)
            );
        }

        $categories = Category::query()
            ->when(
                ! empty($excludeIds),
                function ($query) use ($excludeIds): void {
                    $query->whereNotIn('id', $excludeIds);
                }
            )
            ->orderBy('name')
            ->get();

        return static::buildTree($categories);
    }

    /**
     * Build category tree with indentation.
     */
    private static function buildTree(
        $categories,
        $parentId = null,
        int $level = 0
    ): array {
        $options = [];

        foreach ($categories as $category) {
            if ($category->parent_id == $parentId) {
                $prefix = $level > 0
                    ? str_repeat('— ', $level)
                    : '';

                $options[$category->id] =
                    $prefix . $category->name;

                $options += static::buildTree(
                    $categories,
                    $category->id,
                    $level + 1
                );
            }
        }

        return $options;
    }

    /**
     * Get all descendant category IDs.
     */
    private static function getDescendantIds($category): array
    {
        $ids = [];

        foreach ($category->children as $child) {
            $ids[] = $child->id;

            $ids = array_merge(
                $ids,
                static::getDescendantIds($child)
            );
        }

        return $ids;
    }
}
