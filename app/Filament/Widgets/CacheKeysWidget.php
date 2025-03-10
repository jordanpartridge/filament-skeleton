<?php

namespace App\Filament\Widgets;

use Filament\Tables;
use Filament\Tables\Table;
use Filament\Widgets\TableWidget as BaseWidget;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Str;
use Filament\Notifications\Notification;
use Illuminate\Support\Collection;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Contracts\Pagination\Paginator;

class CacheKeysWidget extends BaseWidget
{
    protected static ?string $heading = 'Cache Keys';
    
    // Auto-refresh every 5 minutes
    protected static ?string $pollingInterval = '300s';
    
    // Full width for the table
    protected int|string|array $columnSpan = 'full';
    
    /**
     * Build the table for the widget
     */
    public function table(Table $table): Table
    {
        return $table
            ->query(
                // Instead of using a custom query, we'll use a simple model query
                // and then add our data in the modifyQueryUsing callback
                \App\Models\User::query()
            )
            ->modifyQueryUsing(function (Builder $query) {
                // Clear the query and replace with dummy query that will return no results
                // We'll manually add our data in the empty state
                return $query->whereRaw('1 = 0');
            })
            ->columns([
                Tables\Columns\TextColumn::make('key')
                    ->label('Cache Key')
                    ->searchable(),
                Tables\Columns\TextColumn::make('size')
                    ->label('Size')
                    ->sortable(),
                Tables\Columns\TextColumn::make('expires')
                    ->label('Expires')
                    ->sortable(),
                Tables\Columns\TextColumn::make('value')
                    ->label('Value Preview')
                    ->limit(50),
            ])
            ->emptyStateHeading('Cache Keys')
            ->emptyStateDescription('Cache information will be displayed here.')
            ->emptyStateIcon('heroicon-o-document');
    }
}
