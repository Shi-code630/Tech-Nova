<?php

namespace App\Filament\Resources\ReturnRequests;

use App\Filament\Resources\ReturnRequests\Pages\ListReturnRequests;
use App\Filament\Resources\ReturnRequests\Tables\ReturnRequestsTable;
use App\Models\ReturnRequest;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Tables\Table;

class ReturnRequestResource extends Resource
{
    protected static ?string $model = ReturnRequest::class;

    protected static string|BackedEnum|null $navigationIcon = 'heroicon-o-arrow-uturn-left';

    protected static ?string $navigationLabel = 'Return & Exchange';

    protected static ?string $modelLabel = 'Return / Exchange Request';

    protected static ?string $pluralModelLabel = 'Return & Exchange Requests';

    public static function getNavigationGroup(): ?string
    {
        return 'Sales Management';
    }

    public static function getNavigationSort(): ?int
    {
        return 9;
    }

    public static function getNavigationBadge(): ?string
    {
        $count = ReturnRequest::query()
            ->where('status', ReturnRequest::STATUS_REQUESTED)
            ->count();

        return $count > 0 ? (string) $count : null;
    }

    public static function getNavigationBadgeColor(): ?string
    {
        return 'warning';
    }

    public static function form(Schema $schema): Schema
    {
        return $schema->components([]);
    }

    public static function table(Table $table): Table
    {
        return ReturnRequestsTable::configure($table);
    }

    public static function getRelations(): array
    {
        return [];
    }

    public static function getPages(): array
    {
        return [
            'index' => ListReturnRequests::route('/'),
        ];
    }
}
