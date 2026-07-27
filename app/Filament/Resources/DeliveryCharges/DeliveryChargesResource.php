<?php

namespace App\Filament\Resources;

use App\Filament\Resources\DeliveryCharges\Pages\CreateDeliveryCharges;
use App\Filament\Resources\DeliveryCharges\Pages\EditDeliveryCharges;
use App\Filament\Resources\DeliveryCharges\Pages\ListDeliveryCharges;
use App\Filament\Resources\DeliveryCharges\Schemas\DeliveryChargesForm;
use App\Filament\Resources\DeliveryCharges\Tables\DeliveryChargesTable;
use App\Models\DeliveryCharge;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Components\Form;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;

class DeliveryChargesResource extends Resource
{
    protected static ?string $model = DeliveryCharge::class;

    public static function getNavigationGroup(): ?string
    {
        return 'Shipping & Delivery';
    }

    public static function getNavigationSort(): ?int
    {
        return 18;
    }

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedRectangleStack;

    protected static ?string $recordTitleAttribute = 'district';

    // public static function form(Form $form): Form
    // {
    //     return DeliveryChargesForm::configure($form);
    // }

    public static function table(Table $table): Table
    {
        return DeliveryChargesTable::configure($table);
    }

    public static function getRelations(): array
    {
        return [];
    }

    public static function getPages(): array
    {
        return [
            'index' => ListDeliveryCharges::route('/'),
            'create' => CreateDeliveryCharges::route('/create'),
            'edit' => EditDeliveryCharges::route('/{record}/edit'),
        ];
    }
}
