<?php

namespace App\Filament\Resources\RewardTransactions;

use App\Filament\Resources\RewardTransactions\Pages\CreateRewardTransaction;
use App\Filament\Resources\RewardTransactions\Pages\EditRewardTransaction;
use App\Filament\Resources\RewardTransactions\Pages\ListRewardTransactions;
use App\Filament\Resources\RewardTransactions\Schemas\RewardTransactionForm;
use App\Filament\Resources\RewardTransactions\Tables\RewardTransactionsTable;
use App\Models\RewardTransaction;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;

class RewardTransactionResource extends Resource
{
    protected static ?string $model = RewardTransaction::class;

    public static function getNavigationGroup(): ?string
    {
        return 'Customer Activity';
    }

    public static function getNavigationSort(): ?int
    {
        return 17;
    }

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedRectangleStack;


    protected static ?string $recordTitleAttribute = 'id';

      public static function getGlobalSearchResultDetails($record): array
    {
        return [
            'Customer' => $record->customer_name,
            'Points' => $record->formatted_points,
            'Type' => $record->type_label,
        ];
    }

    public static function form(Schema $schema): Schema
    {
        return RewardTransactionForm::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return RewardTransactionsTable::configure($table);
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
            'index' => ListRewardTransactions::route('/'),
            'create' => CreateRewardTransaction::route('/create'),
            'edit' => EditRewardTransaction::route('/{record}/edit'),
        ];
    }
}
