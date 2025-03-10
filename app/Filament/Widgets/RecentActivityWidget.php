<?php

namespace App\Filament\Widgets;

use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Filament\Widgets\TableWidget as BaseWidget;
use Spatie\Activitylog\Models\Activity;

class RecentActivityWidget extends BaseWidget
{
    // Priority sort order
    protected static ?int $sort = 99;  // Place at the end

    // Full width for better readability
    protected int|string|array $columnSpan = 'full';

    // Better title
    protected static ?string $heading = 'Recent Activity';

    public function table(Table $table): Table
    {
        return $table
            ->query(
                Activity::query()
                    ->with(['causer', 'subject'])
                    ->select('activity_log.*')
                    ->latest('activity_log.created_at')
                    ->limit(10)
            )
            ->columns([
                TextColumn::make('causer.name')
                    ->icon('heroicon-o-user')
                    ->label('User')
                    ->searchable(),

                TextColumn::make('description')
                    ->label('Activity')
                    ->searchable()
                    ->sortable()
                    ->wrap(),

                TextColumn::make('subject.name')
                    ->label('Subject')
                    ->formatStateUsing(fn (string $state): string => str_replace('App\\Models\\', '', $state))
                    ->sortable(),

                TextColumn::make('created_at')
                    ->label('When')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(),
            ])
            ->striped();
    }
}
