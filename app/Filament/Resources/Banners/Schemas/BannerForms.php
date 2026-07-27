<?php

namespace App\Filament\Resources\Banners\Schemas;

use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Schema;

class BannerForms
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('title')
                    ->label('Title')
                    ->required()
                    ->maxLength(255)
                    ->columnSpanFull(),

                TextInput::make('subtitle')
                    ->label('Subtitle')
                    ->maxLength(255)
                    ->columnSpanFull(),

                TextInput::make('button_text')
                    ->label('Button Text')
                    ->maxLength(100),

                TextInput::make('button_link')
                    ->label('Button Link')
                    ->url()
                    ->maxLength(255),

                FileUpload::make('image')
                    ->label('Banner Image')
                    ->image()
                    ->directory('banners')
                    ->disk('public')
                    ->visibility('public')
                    ->imageEditor()
                    ->required()
                    ->maxSize(2048)
                    ->columnSpanFull(),

                TextInput::make('alt_text')
                    ->label('Alt Text')
                    ->maxLength(255)
                    ->columnSpanFull(),

                Toggle::make('status')
                    ->label('Active')
                    ->default(true),

                TextInput::make('sort_order')
                    ->label('Sort Order')
                    ->numeric()
                    ->default(0)
                    ->required(),
            ])
            ->columns(2);
    }
}
