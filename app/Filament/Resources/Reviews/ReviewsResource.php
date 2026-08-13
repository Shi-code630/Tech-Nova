<?php

namespace App\Filament\Resources\Reviews;

use App\Filament\Resources\Reviews\Pages\CreateReviews;
use App\Filament\Resources\Reviews\Pages\EditReviews;
use App\Filament\Resources\Reviews\Pages\ListReviews;
use App\Filament\Resources\Reviews\Schemas\ReviewsForm;
use App\Filament\Resources\Reviews\Tables\ReviewsTable;
use App\Models\Review;
use App\Models\Reviews;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;

class ReviewsResource extends Resource
{
    protected static ?string $model = Review::class;

    public static function getNavigationGroup(): ?string
    {
        return 'Marketing';
    }

    public static function getNavigationSort(): ?int
    {
        return 13;
    }

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedStar;

    protected static ?string $recordTitleAttribute = 'review';

    public static function form(Schema $schema): Schema
    {
        return ReviewsForm::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return ReviewsTable::configure($table);
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
            'index' => ListReviews::route('/'),
            'create' => CreateReviews::route('/create'),
            'edit' => EditReviews::route('/{record}/edit'),
        ];
    }
}
