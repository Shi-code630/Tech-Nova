<?php

namespace App\Filament\Resources\ContactMessages;

use App\Filament\Resources\ContactMessages\Pages\CreateContactMessages;
use App\Filament\Resources\ContactMessages\Pages\EditContactMessages;
use App\Filament\Resources\ContactMessages\Pages\ListContactMessages;
use App\Filament\Resources\ContactMessages\Schemas\ContactMessagesForm;
use App\Filament\Resources\ContactMessages\Tables\ContactMessagesTable;
use App\Models\ContactMessage;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;

class ContactMessagesResource extends Resource
{
    protected static ?string $model = ContactMessage::class;

    public static function getNavigationGroup(): ?string
    {
        return 'Administration';
    }

    public static function getNavigationSort(): ?int
    {
        return 19;
    }

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedEnvelope;

    public static function canViewAny(): bool
    {
        return true;
    }

    //  - Navigation badge for unread messages
    // public static function getNavigationBadge(): ?string
    // {
    //     $count = static::getModel()::where('status', false)->count();
    //     return $count > 0 ? (string) $count : null;
    // }

    public static function getNavigationBadgeColor(): ?string
    {
        return 'danger';
    }

    //  - Global search attributes
    public static function getGloballySearchableAttributes(): array
    {
        return ['name', 'email', 'subject', 'message', 'phone'];
    }

    //  - Global search result details
    public static function getGlobalSearchResultDetails($record): array
    {
        return [
            'From' => $record->name . ' (' . $record->email . ')',
            'Subject' => $record->subject,
            'Status' => $record->status_label,
            'Received' => $record->formatted_date,
        ];
    }

    //  Global search result title
    public static function getGlobalSearchResultTitle($record): string
    {
        return $record->subject ?? 'Contact Message';
    }

    //  Global search result URL
    public static function getGlobalSearchResultUrl($record): ?string
    {
        return static::getUrl('edit', ['record' => $record]);
    }

    public static function form(Schema $schema): Schema
    {
        return ContactMessagesForm::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return ContactMessagesTable::configure($table);
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
            'index' => ListContactMessages::route('/'),
            'create' => CreateContactMessages::route('/create'),
            'edit' => EditContactMessages::route('/{record}/edit'),
        ];
    }
}
