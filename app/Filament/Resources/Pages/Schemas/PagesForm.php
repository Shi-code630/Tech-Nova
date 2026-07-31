<?php

namespace App\Filament\Resources\Pages\Schemas;

use Filament\Forms\Components\RichEditor;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Components\Grid;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;

class PagesForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make('Page Information')
                    ->schema([
                        Grid::make(2)
                            ->schema([
                                TextInput::make('title')
                                    ->label('Page Title')
                                    ->required()
                                    ->maxLength(255)
                                    ->live(onBlur: true)
                                    ->afterStateUpdated(function ($state, callable $set) {
                                        $set('slug', \Illuminate\Support\Str::slug($state));
                                    })
                                    ->placeholder('Enter page title'),

                                TextInput::make('slug')
                                    ->label('Slug')
                                    ->required()
                                    ->maxLength(255)
                                    ->unique(ignoreRecord: true)
                                    ->helperText('URL-friendly version of the page title'),

                                RichEditor::make('content')
                                    ->label('Page Content')
                                    ->required()
                                    //Use available buttons only
                                    ->toolbarButtons([
                                        'bold',
                                        'italic',
                                        'underline',
                                        'strike',
                                        'h2',
                                        'h3',
                                        'bulletList',
                                        'orderedList',
                                        'blockquote',
                                        'link',

                                    ])
                                    ->columnSpanFull()
                                    ->placeholder('Write your page content here...'),
                            ]),
                    ]),

                Section::make('SEO Information')
                    ->schema([
                        Grid::make(1)
                            ->schema([
                                TextInput::make('meta_title')
                                    ->label('Meta Title')
                                    ->maxLength(255)
                                    ->nullable()
                                    ->helperText('Recommended length: 50-60 characters'),

                                Textarea::make('meta_description')
                                    ->label('Meta Description')
                                    ->rows(2)
                                    ->maxLength(65535)
                                    ->nullable()
                                    ->helperText('Recommended length: 150-160 characters'),

                                TextInput::make('meta_keywords')
                                    ->label('Meta Keywords')
                                    ->maxLength(255)
                                    ->nullable()
                                    ->helperText('Comma-separated keywords'),
                            ]),
                    ]),

                Section::make('Status')
                    ->schema([
                        Toggle::make('status')
                            ->label('Active')
                            ->default(true)
                            ->helperText('Enable or disable this page'),
                    ]),
            ]);
    }
}
