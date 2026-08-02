<?php

namespace App\Filament\Resources\DeliveryCharges\Schemas;

use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Schema;

class DeliveryChargesForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('district')
                    ->label('District')
                    ->required()
                    ->maxLength(255)
                    ->unique(table: 'delivery_charges', column: 'district', ignoreRecord: true),

                TextInput::make('charge')
                    ->label('Delivery Charge')
                    ->required()
                    ->numeric()
                    ->prefix('Rs.')
                    ->step(0.01)
                    ->minValue(0)
                    ->maxValue(999999.99),

                Toggle::make('status')
                    ->label('Active')
                    ->default(true)
                    ->onColor('success')
                    ->offColor('danger'),
            ]);
    }
}
