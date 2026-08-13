<?php

namespace App\Filament\Resources\OrderItems;

use App\Filament\Resources\OrderItems\Pages\CreateOrderItems;
use App\Filament\Resources\OrderItems\Pages\EditOrderItems;
use App\Filament\Resources\OrderItems\Pages\ListOrderItems;
use App\Filament\Resources\OrderItems\Schemas\OrderItemsForm;
use App\Filament\Resources\OrderItems\Tables\OrderItemsTable;
use App\Models\OrderItem;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;

class OrderItemsResource extends Resource
{
    protected static ?string $model = OrderItem::class;

    public static function getNavigationGroup(): ?string
    {
        return 'Sales Management';
    }

    public static function getNavigationSort(): ?int
    {
        return 9;
    }

    protected static string|BackedEnum|null $navigationIcon =Heroicon::OutlinedQueueList;

       public static function canViewAny(): bool
    {
        return true;
    }

    public static function form(Schema $schema): Schema
    {
        return OrderItemsForm::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return OrderItemsTable::configure($table);
    }

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => ListOrderItems::route('/'),
            'create' => CreateOrderItems::route('/create'),
            'edit' => EditOrderItems::route('/{record}/edit'),
        ];
    }
}
