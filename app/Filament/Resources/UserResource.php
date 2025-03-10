<?php

namespace App\Filament\Resources;

use App\Filament\Resources\UserResource\Pages\CreateUser;
use App\Filament\Resources\UserResource\Pages\EditUser;
use App\Filament\Resources\UserResource\Pages\ListUserActivities;
use App\Filament\Resources\UserResource\Pages\ListUsers;
use App\Models\User;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables\Actions\Action;
use Filament\Tables\Actions\BulkActionGroup;
use Filament\Tables\Actions\DeleteBulkAction;
use Filament\Tables\Actions\EditAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

class UserResource extends Resource
{
    protected static ?string $model = User::class;

    // Icon from Heroicons
    protected static ?string $navigationIcon = 'heroicon-o-users';

    // Group in sidebar
    protected static ?string $navigationGroup = 'User Management';

    // Custom label in sidebar
    protected static ?string $navigationLabel = 'Users';

    // Order in the sidebar (lower numbers appear first)
    protected static ?int $navigationSort = 1;

    // Labels used throughout the resource
    protected static ?string $modelLabel = 'User';

    protected static ?string $pluralModelLabel = 'Users';

    // Dynamic badge showing total users
    public static function getNavigationBadge(): ?string
    {
        return static::getModel()::count();
    }

    // Badge color (optional)
    public static function getNavigationBadgeColor(): ?string
    {
        return static::getModel()::count() > 10 ? 'warning' : 'primary';
    }

    public static function form(Form $form): Form
    {
        return User::form($form);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('name'),
                TextColumn::make('email'),
            ])
            ->filters([
                //
            ])
            ->actions([
                EditAction::make(),
                Action::make('activities')
                    ->url(fn($record) => UserResource::getUrl('activities', ['record' => $record])),

            ])
            ->bulkActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                ]),
            ]);
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
            'index' => ListUsers::route('/'),
            'create' => CreateUser::route('/create'),
            'edit' => EditUser::route('/{record}/edit'),
            'activities' => ListUserActivities::route('/{record}/activities'),

        ];
    }
}
