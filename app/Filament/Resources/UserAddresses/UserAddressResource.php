<?php

namespace App\Filament\Resources\UserAddresses;

use App\Filament\Resources\UserAddresses\Pages\CreateUserAddress;
use App\Filament\Resources\UserAddresses\Pages\EditUserAddress;
use App\Filament\Resources\UserAddresses\Pages\ListUserAddresses;
use App\Filament\Resources\UserAddresses\Schemas\UserAddressForm;
use App\Filament\Resources\UserAddresses\Tables\UserAddressesTable;
use App\Models\Address;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;

class UserAddressResource extends Resource
{
    protected static ?string $model = Address::class;

    protected static string|\BackedEnum|null $navigationIcon = Heroicon::MapPin;

    protected static ?string $navigationLabel = 'Addresses';

    protected static ?string $modelLabel = 'Address';

    protected static ?string $pluralModelLabel = 'Addresses';

    protected static ?string $recordTitleAttribute = 'city';

    public static function getNavigationGroup(): ?string
    {
        return 'Customer Management';
    }

    public static function getNavigationSort(): ?int
    {
        return 2;
    }

    public static function form(Schema $schema): Schema
    {
        return UserAddressForm::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return UserAddressesTable::configure($table);
    }

    public static function getRelations(): array
    {
        return [];
    }

    public static function getPages(): array
    {
        return [
            'index' => ListUserAddresses::route('/'),
            'create' => CreateUserAddress::route('/create'),
            'edit' => EditUserAddress::route('/{record}/edit'),
        ];
    }

    // public static function getNavigationBadge(): ?string
    // {
    //     return (string) static::getModel()::count();
    // }

    public static function getNavigationBadgeColor(): ?string
    {
        return 'info';
    }
}
