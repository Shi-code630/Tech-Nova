<?php

namespace App\Filament\Resources\Categories\Schemas;

use App\Models\Categorie;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Schema;
use Illuminate\Validation\Rule;

class CategorieForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('name')
                    ->label('Category Name')
                    ->required()
                    ->maxLength(255)
                    ->live(onBlur: true)
                    ->afterStateUpdated(function ($state, callable $set) {
                        $set('slug', \Illuminate\Support\Str::slug($state));
                    }),

                TextInput::make('slug')
                    ->label('Slug')
                    ->required()
                    ->maxLength(255)
                    ->unique(ignoreRecord: true)
                    ->helperText('Unique URL-friendly identifier. Leave blank to auto-generate.'),

                Select::make('parent_id')
                    ->label('Parent Category')
                    ->options(fn ($record) => static::getParentOptions($record))
                    ->searchable()
                    ->nullable()
                    ->helperText('Select a parent category (optional).')
                    ->rule(function ($record) {
                        // Prevent selecting self or descendants as parent
                        $excludedIds = [];
                        if ($record) {
                            // Get all descendants of the current record (including itself)
                            $descendants = $record->allChildren()->pluck('id')->toArray();
                            $excludedIds = array_merge([$record->id], $descendants);
                        }
                        return Rule::notIn($excludedIds);
                    })
                    ->validationMessages([
                        'not_in' => 'You cannot select this category or its sub‑categories as a parent.',
                    ]),

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
            ]);
    }

    /**
     * Build a nested list of categories for the parent select dropdown.
     * Excludes the current record and all its descendants when editing.
     */
    private static function getParentOptions($record = null): array
    {
        // Exclude the current record and its descendants if editing
        $excludeIds = [];
        if ($record) {
            $descendants = $record->allChildren()->pluck('id')->toArray();
            $excludeIds = array_merge([$record->id], $descendants);
        }

        $categories = Categorie::when($excludeIds, function ($query) use ($excludeIds) {
            return $query->whereNotIn('id', $excludeIds);
        })->get();

        return static::buildTree($categories);
    }

    /**
     * Recursively build a hierarchical options array with indentation.
     */
    private static function buildTree($categories, $parentId = null, $level = 0): array
    {
        $options = [];
        foreach ($categories as $category) {
            if ($category->parent_id == $parentId) {
                $indent = str_repeat('—', $level) . ' ';
                $options[$category->id] = ($level > 0 ? $indent : '') . $category->name;
                $options = $options + static::buildTree($categories, $category->id, $level + 1);
            }
        }
        return $options;
    }
}
