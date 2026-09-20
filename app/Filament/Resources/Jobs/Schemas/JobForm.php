<?php

namespace App\Filament\Resources\Jobs\Schemas;

use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Schema;

class JobForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('title')
                    ->label('Job Title')
                    ->required()
                    ->maxLength(255)
                    ->placeholder('e.g. Laravel Developer'),

                Select::make('department')
                    ->label('Department')
                    ->options([
                        'Engineering' => 'Engineering',
                        'Marketing'   => 'Marketing',
                        'Design'      => 'Design',
                        'Support'     => 'Support',
                        'Product'     => 'Product',
                    ])
                    ->required()
                    ->searchable(),

                TextInput::make('location')
                    ->label('Location')
                    ->required()
                    ->default('Kathmandu, Nepal')
                    ->maxLength(255),

                Select::make('type')
                    ->label('Job Type')
                    ->options([
                        'Full-time'  => 'Full-time',
                        'Part-time'  => 'Part-time',
                        'Contract'   => 'Contract',
                        'Internship' => 'Internship',
                    ])
                    ->required(),

                TextInput::make('experience')
                    ->label('Experience Required')
                    ->required()
                    ->placeholder('e.g. 2+ years')
                    ->maxLength(255),

                TextInput::make('posted')
                    ->label('Posted')
                    ->required()
                    ->default('Just now')
                    ->maxLength(255),

                Textarea::make('description')
                    ->label('Job Description')
                    ->rows(6)
                    ->placeholder('Enter the job description...')
                    ->columnSpanFull(),

                Toggle::make('is_published')
                    ->label('Publish this job')
                    ->default(true),
            ]);
    }
}
