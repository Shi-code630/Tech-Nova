<?php

namespace App\Filament\Resources\ProductVariants;

use App\Filament\Resources\ProductVariants\Pages\CreateProductVariants;
use App\Filament\Resources\ProductVariants\Pages\EditProductVariants;
use App\Filament\Resources\ProductVariants\Pages\ListProductVariants;
use App\Filament\Resources\ProductVariants\Schemas\ProductVariantsForm;
use App\Filament\Resources\ProductVariants\Tables\ProductVariantsTable;
use App\Models\ProductVariant;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;

class ProductVariantsResource extends Resource
{
    protected static ?string $model = ProductVariant::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedSwatch;

    protected static ?string $recordTitleAttribute = 'size';

    public static function getNavigationGroup(): ?string
    {
        return 'Product Management';
    }

    public static function getNavigationSort(): ?int
    {
        return 5;
    }

    public static function form(Schema $schema): Schema
    {
        return ProductVariantsForm::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return ProductVariantsTable::configure($table);
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
            'index' => ListProductVariants::route('/'),
            'create' => CreateProductVariants::route('/create'),
            'edit' => EditProductVariants::route('/{record}/edit'),
        ];
    }
}
