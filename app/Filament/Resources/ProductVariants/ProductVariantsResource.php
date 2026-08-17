<?php

namespace App\Filament\Resources\ProductVariants;

use App\Filament\Resources\ProductVariants\Tables\ProductVariantsTable;
use App\Filament\Resources\ProductVariantsResource\Pages\CreateProductVariants;
use App\Filament\Resources\ProductVariantsResource\Pages\EditProductVariants;
use App\Filament\Resources\ProductVariantsResource\Pages\ListProductVariants;
use App\Filament\Resources\ProductVariantsResource\Schemas\ProductVariantsForm;
use App\Models\ProductVariant;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Tables\Table;

class ProductVariantsResource extends Resource
{
    protected static ?string $model = ProductVariant::class;
    protected static bool $shouldRegisterNavigation = false;

    protected static string|BackedEnum|null $navigationIcon = 'heroicon-o-cube';

    public static function getNavigationGroup(): ?string
    {
        return 'Product Management';
    }

    protected static ?string $navigationLabel = 'Product Variants';

    protected static ?int $navigationSort = 3;

    public static function form(Schema $schema): Schema
    {
        return ProductVariantsForm::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return ProductVariantsTable::configure($table);
    }

    public static function getPages(): array
    {
        return [
            'index' => ListProductVariants::route('/'),
            'create' => CreateProductVariants::route('/create'),
            'edit' => EditProductVariants::route('/{record}/edit'),
        ];
    }

    public static function getModelLabel(): string
    {
        return 'Product Variant';
    }

    public static function getPluralModelLabel(): string
    {
        return 'Product Variants';
    }
}
