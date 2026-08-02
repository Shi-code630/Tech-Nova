<?php

namespace App\Filament\Resources\Payments;

use App\Filament\Resources\Payments\Pages\CreatePayments;
use App\Filament\Resources\Payments\Pages\EditPayments;
use App\Filament\Resources\Payments\Pages\ListPayments;
use App\Filament\Resources\Payments\Schemas\PaymentsForm;
use App\Filament\Resources\Payments\Tables\PaymentsTable;
use App\Models\Payment;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;

class PaymentsResource extends Resource
{
    protected static ?string $model = Payment::class;

    public static function getNavigationGroup(): ?string
    {
        return 'Sales Management';
    }

    public static function getNavigationSort(): ?int
    {
        return 10;
    }

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedRectangleStack;

    // ✅ Use transaction_id as record title
    protected static ?string $recordTitleAttribute = 'transaction_id';

    // ✅ ADD THIS - Makes resource visible
    public static function canViewAny(): bool
    {
        return true;
    }

    // public static function getNavigationBadge(): ?string
    // {
    //     $pendingCount = static::getModel()::where('status', 'pending')->count();
    //     return $pendingCount > 0 ? $pendingCount : null;
    // }

    public static function getNavigationBadgeColor(): ?string
    {
        return 'warning';
    }

    public static function getGloballySearchableAttributes(): array
    {
        return ['transaction_id', 'order.order_number', 'payment_method'];
    }

    public static function getGlobalSearchResultDetails($record): array
    {
        return [
            'Order' => $record->order?->order_number,
            'Amount' => $record->formatted_amount,
            'Status' => $record->status_label,
        ];
    }

    public static function form(Schema $schema): Schema
    {
        return PaymentsForm::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return PaymentsTable::configure($table);
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
            'index' => ListPayments::route('/'),
            'create' => CreatePayments::route('/create'),
            'edit' => EditPayments::route('/{record}/edit'),
        ];
    }
}
