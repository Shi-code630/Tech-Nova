<?php

namespace App\Filament\Resources\ShoppingCarts;
use App\Filament\Resources\ShoppingCarts\Pages\CreateShoppingCarts;
use App\Filament\Resources\ShoppingCarts\Pages\EditShoppingCarts;
use App\Filament\Resources\ShoppingCarts\Pages\ListShoppingCarts;
use App\Filament\Resources\ShoppingCarts\Schemas\ShoppingCartsForm;
use App\Filament\Resources\ShoppingCarts\Tables\ShoppingCartsTable;
use App\Models\Cart;
use App\Models\ShoppingCarts;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;

class ShoppingCartsResource extends Resource
{
    protected static ?string $model = Cart::class;

     public static function getNavigationGroup(): ?string
    {
        return 'Customer Activity';
    }

    public static function getNavigationSort(): ?int
    {
        return 15;
    }

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedRectangleStack;

    protected static ?string $recordTitleAttribute = 'name';

    public static function form(Schema $schema): Schema
    {
        return ShoppingCartsForm::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return ShoppingCartsTable::configure($table);
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
            'index' => ListShoppingCarts::route('/'),
            'create' => CreateShoppingCarts::route('/create'),
            'edit' => EditShoppingCarts::route('/{record}/edit'),
        ];
    }
}
