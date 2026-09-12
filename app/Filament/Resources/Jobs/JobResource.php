<?php

namespace App\Filament\Resources\Jobs;

use App\Filament\Resources\Jobs\Pages\CreateJob;
use App\Filament\Resources\Jobs\Pages\EditJob;
use App\Filament\Resources\Jobs\Pages\ListJobs;
use App\Filament\Resources\Jobs\Schemas\JobForm;
use App\Filament\Resources\Jobs\Tables\JobsTable;
use App\Models\Job;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;

class JobResource extends Resource
{
    protected static ?string $model = Job::class;

    /**
     * Navigation group
     */
    public static function getNavigationGroup(): ?string
    {
        return 'HR Management';
    }

    /**
     * Navigation order
     */
    public static function getNavigationSort(): ?int
    {
        return 10;
    }

    /**
     * Navigation icon — Heroicon
     */
    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedBriefcase;

    /**
     * Navigation label
     */
    protected static ?string $navigationLabel = 'Job Posts';

    /**
     * Model label (singular)
     */
    protected static ?string $modelLabel = 'Job Post';

    /**
     * Model label (plural)
     */
    protected static ?string $pluralModelLabel = 'Job Posts';

    /**
     * Allow resource to be visible
     */
    public static function canViewAny(): bool
    {
        return true;
    }

    public static function form(Schema $schema): Schema
    {
        return JobForm::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return JobsTable::configure($table);
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
            'index'  => ListJobs::route('/'),
            'create' => CreateJob::route('/create'),
            'edit'   => EditJob::route('/{record}/edit'),
        ];
    }
}
