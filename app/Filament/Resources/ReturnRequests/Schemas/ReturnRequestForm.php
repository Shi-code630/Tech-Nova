<?php

namespace App\Filament\Resources\ReturnRequests\Schemas;

use Filament\Forms\Components\DateTimePicker;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Schemas\Schema;

class ReturnRequestForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Select::make('order_id')
                    ->relationship('order', 'id')
                    ->required(),
                Select::make('order_item_id')
                    ->relationship('orderItem', 'id')
                    ->required(),
                Select::make('user_id')
                    ->relationship('user', 'name')
                    ->required(),
                Select::make('request_type')
                    ->options(['return' => 'Return', 'exchange' => 'Exchange'])
                    ->required(),
                Select::make('exchange_variant_id')
                    ->relationship('exchangeVariant', 'id')
                    ->default(null),
                TextInput::make('quantity')
                    ->required()
                    ->numeric(),
                Textarea::make('reason')
                    ->required()
                    ->columnSpanFull(),
                FileUpload::make('image')
                    ->image(),
                Select::make('status')
                    ->options([
            'requested' => 'Requested',
            'approved' => 'Approved',
            'rejected' => 'Rejected',
            'received' => 'Received',
            'completed' => 'Completed',
        ])
                    ->default('requested')
                    ->required(),
                Textarea::make('admin_note')
                    ->default(null)
                    ->columnSpanFull(),
                DateTimePicker::make('approved_at'),
                DateTimePicker::make('received_at'),
                DateTimePicker::make('completed_at'),
            ]);
    }
}
