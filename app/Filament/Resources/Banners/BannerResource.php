<?php

namespace App\Filament\Resources\Banners;

use App\Filament\Resources\Banners\Pages\CreateBanner;
use App\Filament\Resources\Banners\Pages\EditBanner;
use App\Filament\Resources\Banners\Pages\ListBanners;
use App\Filament\Resources\Banners\Schemas\BannerForms;
use App\Filament\Resources\Banners\Tables\BannerTable;
use App\Models\Banner;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;

class BannerResource extends Resource
{
    protected static ?string $model = Banner::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedPhoto;

    protected static ?string $recordTitleAttribute = 'title';

    public static function getNavigationLabel(): string
    {
        return 'Banners';
    }

    public static function getPluralModelLabel(): string
    {
        return 'Banners';
    }

    public static function getModelLabel(): string
    {
        return 'Banner';
    }

    public static function getNavigationGroup(): ?string
    {
        return 'Marketing';
    }

    public static function getNavigationSort(): ?int
    {
        return 12;
    }

    public static function form(Schema $schema): Schema
    {
        return BannerForms::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return BannerTable::configure($table);
    }

    public static function getRelations(): array
    {
        return [];
    }

    public static function getPages(): array
    {
        return [
            'index' => ListBanners::route('/'),
            'create' => CreateBanner::route('/create'),
            'edit' => EditBanner::route('/{record}/edit'),
        ];
    }

    public static function getNavigationBadge(): ?string
    {
        $count = Banner::where('status', true)->count();

        return $count > 0 ? (string) $count : null;
    }

    public static function getNavigationBadgeColor(): ?string
    {
        return 'success';
    }
}

