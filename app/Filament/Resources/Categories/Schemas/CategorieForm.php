<?php

namespace App\Filament\Resources\Categories\Schemas;

use App\Models\Categorie;
use Filament\Forms\Components\Grid;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\Toggle;
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
                    ->schema([
                        Grid::make(2)
                            ->schema([

                                TextInput::make('name')
                                    ->label('Category Name')
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
                                    ->unique(ignoreRecord: true),

                                Select::make('parent_id')
                                    ->label('Parent Category')
                                    ->options(fn ($record) => static::getParentOptions($record))
                                    ->searchable()
                                    ->preload()
                                    ->nullable()
                                    ->helperText('Optional')
                                    ->rule(function ($record) {
                                        $excludedIds = [];

                                        if ($record) {
                                            $descendants = $record->allChildren()->pluck('id')->toArray();
                                            $excludedIds = array_merge([$record->id], $descendants);
                                        }

                                        return Rule::notIn($excludedIds);
                                    })
                                    ->validationMessages([
                                        'not_in' => 'You cannot select this category or its children as parent.',
                                    ]),

                                Toggle::make('status')
                                    ->label('Active')
                                    ->default(true),

                            ]),

                        Textarea::make('description')
                            ->label('Description')
                            ->rows(5),

                        Section::make('SEO')
                            ->schema([

                                TextInput::make('meta_title')
                                    ->maxLength(255),

                                Textarea::make('meta_description')
                                    ->rows(3),

                                TextInput::make('meta_keywords')
                                    ->maxLength(255),

                            ]),
                    ]),
            ]);
    }

    private static function getParentOptions($record = null): array
    {
        $excludeIds = [];

        if ($record) {
            $descendants = $record->allChildren()->pluck('id')->toArray();
            $excludeIds = array_merge([$record->id], $descendants);
        }

        $categories = Category::query()
            ->when(!empty($excludeIds), function ($query) use ($excludeIds) {
                $query->whereNotIn('id', $excludeIds);
            })
            ->orderBy('name')
            ->get();

        return static::buildTree($categories);
    }

    private static function buildTree($categories, $parentId = null, $level = 0): array
    {
        $options = [];

        foreach ($categories as $category) {
            if ($category->parent_id == $parentId) {

                $options[$category->id] =
                    str_repeat('— ', $level) . $category->name;

                $options += static::buildTree(
                    $categories,
                    $category->id,
                    $level + 1
                );
            }
        }

        return $options;
    }
}
