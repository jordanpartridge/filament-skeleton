<?php

namespace App\Filament\Resources;

use App\Filament\Resources\UserResource\Pages;
use App\Filament\Widgets\UserStatsWidget;
use App\Models\User;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Actions\Action;
use Filament\Tables\Actions\BulkActionGroup;
use Filament\Tables\Actions\DeleteBulkAction;
use Filament\Tables\Actions\EditAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\BadgeColumn;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules\Password;

class UserResource extends Resource
{
    protected static ?string $model = User::class;

    protected static ?string $navigationIcon = 'heroicon-o-users';

    protected static ?string $navigationGroup = 'User Management';

    protected static ?string $navigationLabel = 'Users';

    protected static ?int $navigationSort = 1;

    protected static ?string $modelLabel = 'User';

    protected static ?string $pluralModelLabel = 'Users';

    protected static ?string $navigationBadge = null;

    public static function getNavigationBadge(): ?string
    {
        return static::getModel()::count();
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('id')
                    ->label('ID')
                    ->sortable()
                    ->toggleable()
                    ->prefix('#'),

                TextColumn::make('name')
                    ->searchable()
                    ->sortable()
                    ->copyable()
                    ->wrap()
                    ->description(fn(User $record): string => $record->email)
                    ->copyMessage('Name copied')
                    ->searchable(),

                TextColumn::make('email')
                    ->searchable()
                    ->sortable()
                    ->copyable()
                    ->icon('heroicon-m-envelope')
                    ->color('gray')
                    ->copyMessage('Email copied'),

                TextColumn::make('created_at')
                    ->label('Joined')
                    ->date('M j, Y')
                    ->sortable()
                    ->toggleable()
                    ->color('gray'),


            ])
            ->defaultSort('created_at', 'desc')
            ->filters([
                //
            ])
            ->actions([
                EditAction::make()
                    ->iconButton(),
                Action::make('activities')
                    ->iconButton()
                    ->icon('heroicon-m-clock')
                    ->url(fn($record) => UserResource::getUrl('activities', ['record' => $record])),
            ])
            ->bulkActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                ]),
            ]);
    }


    public static function getWidgets(): array
    {
        return [
            UserStatsWidget::class,
        ];
    }

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Section::make('Basic Information')
                    ->description('Update the user\'s main account details.')
                    ->icon('heroicon-o-user-circle')
                    ->columns(['sm' => 2])
                    ->schema([
                        TextInput::make('name')
                            ->required()
                            ->maxLength(255)
                            ->placeholder('Enter full name')
                            ->columnSpan(1),

                        TextInput::make('email')
                            ->email()
                            ->required()
                            ->maxLength(255)
                            ->placeholder('email@example.com')
                            ->columnSpan(1),
                    ]),

                Section::make('Security')
                    ->description('Ensure the account is using a long, random password to stay secure.')
                    ->icon('heroicon-o-shield-check')
                    ->columns(['sm' => 2])
                    ->schema([
                        TextInput::make('password')
                            ->password()
                            ->dehydrateStateUsing(fn($state) => Hash::make($state))
                            ->dehydrated(fn($state) => filled($state))
                            ->required(fn(string $context): bool => $context === 'create')
                            ->rule(Password::default())
                            ->autocomplete('new-password')
                            ->label(fn(string $context): string =>
                            $context === 'edit' ? 'New Password' : 'Password'
                            )
                            ->helperText(fn(string $context): string =>
                            $context === 'edit'
                                ? 'Leave blank to keep current password'
                                : 'Choose a secure password'
                            )
                            ->columnSpan(1),

                        TextInput::make('password_confirmation')
                            ->password()
                            ->dehydrated(false)
                            ->required(fn(string $context): bool => $context === 'create')
                            ->visible(fn(string $context): bool => $context === 'create')
                            ->same('password')
                            ->autocomplete('new-password')
                            ->label('Confirm Password')
                            ->columnSpan(1),
                    ]),
            ]);
    }

    public static function getGloballySearchableAttributes(): array
    {
        return [
            'name',
            'email',
            'id',
        ];
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
            'index'      => Pages\ListUsers::route('/'),
            'create'     => Pages\CreateUser::route('/create'),
            'edit'       => Pages\EditUser::route('/{record}/edit'),
            'activities' => Pages\ListUserActivities::route('/{record}/activities'),
        ];
    }
}
