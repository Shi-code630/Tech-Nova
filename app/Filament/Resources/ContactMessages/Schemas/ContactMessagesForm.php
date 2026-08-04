<?php

namespace App\Filament\Resources\ContactMessages\Schemas;

use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Components\Grid;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;

class ContactMessagesForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make('Contact Message Details')
                    ->schema([
                        Grid::make(2)
                            ->schema([
                                TextInput::make('name')
                                    ->label('Name')
                                    ->required()
                                    ->maxLength(255)
                                    ->disabled()
                                    ->dehydrated(),

                                TextInput::make('email')
                                    ->label('Email')
                                    ->email()
                                    ->required()
                                    ->maxLength(255)
                                    ->disabled()
                                    ->dehydrated(),

                                TextInput::make('phone')
                                    ->label('Phone')
                                    ->maxLength(255)
                                    ->nullable()
                                    ->disabled()
                                    ->dehydrated(),

                                TextInput::make('subject')
                                    ->label('Subject')
                                    ->required()
                                    ->maxLength(255)
                                    ->disabled()
                                    ->dehydrated(),

                                Textarea::make('message')
                                    ->label('Message')
                                    ->required()
                                    ->rows(6)
                                    ->disabled()
                                    ->dehydrated(),

                                Toggle::make('status')
                                    ->label('Mark as Read')
                                    ->default(false)
                                    ->helperText('Mark this message as read'),
                            ]),
                    ]),
            ]);
    }
}
