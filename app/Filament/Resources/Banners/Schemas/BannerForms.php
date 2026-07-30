<?php

namespace App\Filament\Resources\Banners\Schemas;

use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Components\Grid;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;

class BannerForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make('Banner Information')
                    ->schema([
                        Grid::make(2)
                            ->schema([
                                TextInput::make('title')
                                    ->label('Title')
                                    ->required()
                                    ->maxLength(255)
                                    ->placeholder('Enter banner title'),

                                TextInput::make('subtitle')
                                    ->label('Subtitle')
                                    ->maxLength(255)
                                    ->nullable()
                                    ->placeholder('Enter banner subtitle'),

                                Textarea::make('alt_text')
                                    ->label('Alt Text (SEO)')
                                    ->maxLength(65535)
                                    ->nullable()
                                    ->helperText('Alternative text for SEO and accessibility'),

                                TextInput::make('button_text')
                                    ->label('Button Text')
                                    ->maxLength(255)
                                    ->nullable()
                                    ->placeholder('e.g. Shop Now, Learn More'),

                                TextInput::make('button_link')
                                    ->label('Button Link')
                                    ->url()
                                    ->maxLength(255)
                                    ->nullable()
                                    ->placeholder('e.g. /products or https://example.com'),

                                FileUpload::make('image')
                                    ->label('Banner Image')
                                    ->image()
                                    ->directory('banners')
                                    ->maxSize(5120)
                                    ->imageResizeMode('cover')
                                    ->imageCropAspectRatio('16:9')
                                    ->imageResizeTargetWidth('1200')
                                    ->imageResizeTargetHeight('675')
                                    ->imageResizeUpscale(false)
                                   
                                    ->required()
                                    ->helperText('Upload a banner image (max 5MB). 16:9 ratio recommended (1200x675px)'),
                            ]),
                    ]),

                Section::make('Display Settings')
                    ->schema([
                        Grid::make(2)
                            ->schema([
                                TextInput::make('sort_order')
                                    ->label('Sort Order')
                                    ->numeric()
                                    ->default(0)
                                    ->minValue(0)
                                    ->helperText('Lower numbers appear first'),

                                Toggle::make('status')
                                    ->label('Active')
                                    ->default(true)
                                    ->helperText('Enable or disable this banner'),
                            ]),
                    ]),
            ]);
    }
}
