<?php

namespace App\Filament\Resources\SpinRewards;

use App\Filament\Resources\SpinRewards\Pages\CreateSpinReward;
use App\Filament\Resources\SpinRewards\Pages\EditSpinReward;
use App\Filament\Resources\SpinRewards\Pages\ListSpinRewards;
use App\Filament\Resources\SpinRewards\Schemas\SpinRewardForm;
use App\Models\SpinReward;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Tables;
use Filament\Tables\Table;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteAction;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use UnitEnum;

class SpinRewardResource extends Resource
{
    protected static ?string $model = SpinReward::class;

    protected static string|BackedEnum|null $navigationIcon = 'heroicon-o-gift';

    protected static string|UnitEnum|null $navigationGroup = 'Spin & Win';

    protected static ?string $navigationLabel = 'Spin Rewards';

    protected static ?string $modelLabel = 'Spin Reward';

    protected static ?string $pluralModelLabel = 'Spin Rewards';

    protected static ?int $navigationSort = 1;

    public static function form(Schema $schema): Schema
    {
        return SpinRewardForm::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('name')
                    ->label('Reward')
                    ->searchable()
                    ->sortable(),

                Tables\Columns\TextColumn::make('type')
                    ->badge()
                    ->formatStateUsing(
                        fn (string $state): string => match ($state) {
                            'discount' => 'Discount',
                            'coins' => 'Coins',
                            'gift' => 'Gift',
                            default => ucfirst($state),
                        }
                    )
                    ->color(
                        fn (string $state): string => match ($state) {
                            'discount' => 'warning',
                            'coins' => 'success',
                            'gift' => 'info',
                            default => 'gray',
                        }
                    ),

                Tables\Columns\TextColumn::make('discount_percent')
                    ->label('Discount')
                    ->formatStateUsing(
                        fn ($state) => $state ? $state . '%' : '-'
                    ),

                Tables\Columns\TextColumn::make('coins')
                    ->label('Coins')
                    ->formatStateUsing(
                        fn ($state) => $state ? number_format($state) : '-'
                    ),

                Tables\Columns\TextColumn::make('probability')
                    ->label('Probability')
                    ->suffix('%')
                    ->sortable(),

                Tables\Columns\TextColumn::make('stock')
                    ->label('Stock')
                    ->formatStateUsing(
                        fn ($state) => $state === null ? 'Unlimited' : number_format($state)
                    )
                    ->sortable(),

                Tables\Columns\IconColumn::make('status')
                    ->label('Active')
                    ->boolean()
                    ->sortable(),

                Tables\Columns\TextColumn::make('created_at')
                    ->label('Created')
                    ->dateTime('d M Y, h:i A')
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                Tables\Filters\SelectFilter::make('type')
                    ->options([
                        'discount' => 'Discount',
                        'coins' => 'Coins',
                        'gift' => 'Gift',
                    ]),

                Tables\Filters\TernaryFilter::make('status')
                    ->label('Active Status'),
            ])
            ->actions([
                EditAction::make(),
                DeleteAction::make(),
            ])
            ->bulkActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                ]),
            ])
            ->defaultSort('created_at', 'desc');
    }

    public static function getRelations(): array
    {
        return [];
    }

    public static function getPages(): array
    {
        return [
            'index' => ListSpinRewards::route('/'),
            'create' => CreateSpinReward::route('/create'),
            'edit' => EditSpinReward::route('/{record}/edit'),
        ];
    }
}
