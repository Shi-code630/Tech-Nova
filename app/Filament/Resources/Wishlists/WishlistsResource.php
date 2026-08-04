<?php

namespace App\Filament\Resources\Wishlists;

use App\Filament\Resources\Wishlists\Pages\CreateWishlists;
use App\Filament\Resources\Wishlists\Pages\EditWishlists;
use App\Filament\Resources\Wishlists\Pages\ListWishlists;
use App\Filament\Resources\Wishlists\Schemas\WishlistsForm;
use App\Filament\Resources\Wishlists\Tables\WishlistsTable;
use App\Models\Wishlist;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;

class WishlistsResource extends Resource
{
    protected static ?string $model = Wishlist::class;

    public static function getNavigationGroup(): ?string
    {
        return 'Customer Activity';
    }

    public static function getNavigationSort(): ?int
    {
        return 16;
    }

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedHeart;

    

    public static function canViewAny(): bool
    {
        return true;
    }

    // public static function getNavigationBadge(): ?string
    // {
    //     $count = static::getModel()::count();
    //     return $count > 0 ? (string) $count : null;
    // }

    public static function getNavigationBadgeColor(): ?string
    {
        return 'danger';
    }

    public static function getGloballySearchableAttributes(): array
    {
        return ['product.name', 'user.name'];
    }

    public static function getGlobalSearchResultDetails($record): array
    {
        return [
            'Product' => $record->product_name,
            'Customer' => $record->customer_name,
            'Added' => $record->added_at,
        ];
    }

    public static function form(Schema $schema): Schema
    {
        return WishlistsForm::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return WishlistsTable::configure($table);
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
            'index' => ListWishlists::route('/'),
            'create' => CreateWishlists::route('/create'),
            'edit' => EditWishlists::route('/{record}/edit'),
        ];
    }
}
