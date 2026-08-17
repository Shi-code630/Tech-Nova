<?php

namespace App\Filament\Resources\UserAddresses\Schemas;

use App\Models\User;
use Filament\Forms\Components\Placeholder;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Components\Grid;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;

class UserAddressForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make('User Information')
                    ->columnSpanFull()
                    ->schema([
                        Select::make('user_id')
                            ->label('User')
                            ->required()
                            ->searchable()
                            ->preload()
                            ->options(User::query()->pluck('name', 'id'))
                            ->helperText('Select the user this address belongs to')
                            ->prefixIcon('heroicon-o-user'),
                    ]),

                Section::make('Address Details')
                 ->columnSpanFull()
                    ->schema([
                        Grid::make(2)
                            ->schema([
                                TextInput::make('full_name')
                                    ->label('Full Name')
                                    ->required()
                                    ->maxLength(255)
                                    ->placeholder('Enter full name')
                                    ->prefixIcon('heroicon-o-user'),

                                TextInput::make('phone')
                                    ->label('Phone Number')
                                    ->required()
                                    ->tel()
                                    ->maxLength(20)
                                    ->placeholder('Enter phone number')
                                    ->prefixIcon('heroicon-o-phone'),
                            ]),

                        Grid::make(2)
                            ->schema([
                                TextInput::make('province')
                                    ->label('Province')
                                    ->required()
                                    ->maxLength(255)
                                    ->placeholder('Enter province')
                                    ->prefixIcon('heroicon-o-map-pin'),

                                TextInput::make('district')
                                    ->label('District')
                                    ->required()
                                    ->maxLength(255)
                                    ->placeholder('Enter district')
                                    ->prefixIcon('heroicon-o-map-pin'),
                            ]),

                        Grid::make(2)
                            ->schema([
                                TextInput::make('city')
                                    ->label('City')
                                    ->required()
                                    ->maxLength(255)
                                    ->placeholder('Enter city')
                                    ->prefixIcon('heroicon-o-building-office-2'),

                                TextInput::make('postal_code')
                                    ->label('Postal Code')
                                    ->maxLength(20)
                                    ->placeholder('Enter postal code')
                                    ->prefixIcon('heroicon-o-numbered-list'),
                            ]),

                        TextInput::make('address')
                            ->label('Street Address')
                            ->required()
                            ->maxLength(65535)
                            ->placeholder('Enter street address')
                            ->prefixIcon('heroicon-o-home')
                            ->columnSpanFull(),

                        Toggle::make('is_default')
                            ->label('Default Address')
                            ->default(false)
                            ->helperText('Set this as the default address for the user')
                            ->onColor('success')
                            ->offColor('gray'),
                    ]),

                Section::make('Address Summary')

                    ->schema([
                        Placeholder::make('full_address')
                            ->label('Full Address')
                            ->content(
                                fn($record) =>
                                $record ? $record->full_address : 'No address entered yet'
                            )
                            ->columnSpanFull(),
                    ])
                    ->visible(fn($operation) => $operation === 'edit'),

                Section::make('Timestamps')
                    ->schema([
                        Grid::make(2)
                            ->schema([
                                Placeholder::make('created_at')
                                    ->label('Created At')
                                    ->content(
                                        fn($record) =>
                                        $record ? $record->created_at->format('F j, Y, g:i A') : 'N/A'
                                    ),

                                Placeholder::make('updated_at')
                                    ->label('Last Updated')
                                    ->content(
                                        fn($record) =>
                                        $record ? $record->updated_at->format('F j, Y, g:i A') : 'N/A'
                                    ),
                            ]),
                    ])
                    ->visible(fn($operation) => $operation === 'edit'),
            ]);
    }
}
