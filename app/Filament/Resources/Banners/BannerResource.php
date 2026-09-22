<?php

namespace App\Filament\Resources\Banners;

use App\Filament\Resources\Banners\Pages\CreateBanner;
use App\Filament\Resources\Banners\Pages\EditBanners;
use App\Filament\Resources\Banners\Pages\ListBanners;
use App\Models\Banner;
use BackedEnum;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteAction;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Actions\ViewAction;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Radio;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Resources\Resource;
use Filament\Schemas\Components\Grid;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Columns\ImageColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Columns\ToggleColumn;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Filters\TernaryFilter;
use Filament\Tables\Table;

class BannerResource extends Resource
{
    protected static ?string $model = Banner::class;

    public static function getNavigationGroup(): ?string
    {
        return 'Marketing';
    }

    public static function getNavigationSort(): ?int
    {
        return 12;
    }

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedPhoto;

    protected static ?string $recordTitleAttribute = 'title';

    public static function canViewAny(): bool
    {
        return true;
    }

    public static function getNavigationBadgeColor(): ?string
    {
        return 'success';
    }

    public static function getGloballySearchableAttributes(): array
    {
        return ['title', 'subtitle', 'alt_text'];
    }

    public static function getGlobalSearchResultDetails($record): array
    {
        return [
            'Status' => $record->status_label ?? ($record->status ? 'Active' : 'Inactive'),
            'Order' => $record->sort_order,
        ];
    }

    public static function form(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make('Banner Information')
                    ->columnSpanFull()
                    ->schema([
                        Grid::make(2)
                            ->schema([
                                Radio::make('type')
                                    ->label('Banner Type')
                                    ->options([
                                        'main' => 'Main Banner (homepage hero, 1920x600)',
                                        'small' => 'Small Banner (body/promo, 800x400)',
                                    ])
                                    ->default('main')
                                    ->required()
                                    ->columnSpanFull()
                                    ->inline(),

                                TextInput::make('title')
                                    ->label('Title')
                                    ->required()
                                    ->maxLength(255)
                                    ->placeholder('Enter banner title'),

                                TextInput::make('subtitle')
                                    ->label('Subtitle')
                                    ->maxLength(255)
                                    ->nullable()
                                    ->placeholder('Enter banner subtitle'),

                                Textarea::make('alt_text')
                                    ->label('Alt Text (SEO)')
                                    ->maxLength(65535)
                                    ->nullable()
                                    ->helperText('Alternative text for SEO and accessibility'),

                                TextInput::make('button_text')
                                    ->label('Button Text')
                                    ->maxLength(255)
                                    ->nullable()
                                    ->placeholder('e.g. Shop Now, Learn More'),

                                TextInput::make('button_link')
                                    ->label('Button Link')
                                    ->url()
                                    ->maxLength(255)
                                    ->nullable()
                                    ->placeholder('e.g. /products or https://example.com')
                                    ->helperText('Enter the URL where users will be redirected when clicking the button.'),

                                FileUpload::make('image')
                                    ->label('Banner Image')
                                    ->image()
                                    ->disk('public')
                                    ->directory('banners')
                                    ->visibility('public')
                                    ->maxSize(5120)
                                    ->imageResizeMode('cover')
                                    ->imageCropAspectRatio('16:5')
                                    ->imageResizeTargetWidth('1920')
                                    ->imageResizeTargetHeight('600')
                                    ->imageResizeUpscale(false)
                                    ->required()
                                    ->helperText('Main: 1920x600 | Small: ~800x400 | Max 5MB'),
                            ]),
                    ]),

                Section::make('Display Settings')
                    ->schema([
                        Grid::make(2)
                            ->schema([
                                TextInput::make('sort_order')
                                    ->label('Sort Order')
                                    ->numeric()
                                    ->default(0)
                                    ->minValue(0)
                                    ->helperText('Lower numbers appear first'),

                                Toggle::make('status')
                                    ->label('Active')
                                    ->default(true)
                                    ->helperText('Enable or disable this banner'),
                            ]),
                    ]),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                ImageColumn::make('image')
                    ->label('Image')
                    ->disk('public')
                    ->square()
                    ->size(60),

                TextColumn::make('type')
                    ->label('Type')
                    ->badge()
                    ->color(fn (string $state) => $state === 'main' ? 'primary' : 'gray')
                    ->formatStateUsing(fn (string $state) => $state === 'main' ? 'Main' : 'Small')
                    ->sortable(),

                TextColumn::make('title')
                    ->label('Title')
                    ->searchable()
                    ->sortable()
                    ->weight('bold'),

                TextColumn::make('subtitle')
                    ->label('Subtitle')
                    ->searchable()
                    ->toggleable(isToggledHiddenByDefault: true),

                TextColumn::make('button_text')
                    ->label('Button')
                    ->searchable()
                    ->toggleable(isToggledHiddenByDefault: true),

                TextColumn::make('sort_order')
                    ->label('Order')
                    ->sortable()
                    ->toggleable(),

                ToggleColumn::make('status')
                    ->label('Active')
                    ->sortable(),

                TextColumn::make('created_at')
                    ->label('Created')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),

                TextColumn::make('updated_at')
                    ->label('Updated')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->defaultSort('sort_order', 'asc')
            ->filters([
                SelectFilter::make('type')
                    ->label('Banner Type')
                    ->options([
                        'main' => 'Main',
                        'small' => 'Small',
                    ]),

                TernaryFilter::make('status')
                    ->label('Active Status')
                    ->placeholder('All Banners')
                    ->trueLabel('Active Only')
                    ->falseLabel('Inactive Only'),
            ])
            ->recordActions([
                ViewAction::make()
                    ->label('View')
                    ->color('warning')
                    ->icon('heroicon-o-eye'),

                EditAction::make()
                    ->label('Edit')
                    ->color('warning')
                    ->icon('heroicon-o-pencil-square'),

                DeleteAction::make()
                    ->label('Delete')
                    ->icon('heroicon-o-trash')
                    ->color('warning')
                    ->requiresConfirmation()
                    ->modalHeading('Delete Banner')
                    ->modalDescription('Are you sure you want to delete this banner? This action cannot be undone.')
                    ->modalSubmitActionLabel('Yes, Delete'),
            ])
            ->bulkActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make()
                        ->label('Delete Selected')
                        ->color('danger')
                        ->icon('heroicon-o-trash')
                        ->requiresConfirmation()
                        ->modalHeading('Delete Selected Banners')
                        ->modalDescription('Are you sure you want to delete the selected banners? This action cannot be undone.'),
                ]),
            ])
            ->striped()
            ->paginated([10, 25, 50, 100])
            ->searchable();
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
            'edit' => EditBanners::route('/{record}/edit'),
        ];
    }
}
