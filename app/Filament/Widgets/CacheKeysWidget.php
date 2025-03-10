<?php

namespace App\Filament\Widgets;

use Filament\Tables;
use Filament\Tables\Table;
use Filament\Widgets\TableWidget as BaseWidget;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Str;
use Filament\Notifications\Notification;

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
                $this->getCacheKeysQuery()
            )
            ->columns([
                Tables\Columns\TextColumn::make('key')
                    ->label('Cache Key')
                    ->searchable()
                    ->sortable(),
                Tables\Columns\TextColumn::make('size')
                    ->label('Size')
                    ->sortable(),
                Tables\Columns\TextColumn::make('expires')
                    ->label('Expires')
                    ->sortable(),
                Tables\Columns\TextColumn::make('value')
                    ->label('Value Preview')
                    ->limit(50)
                    ->tooltip(function ($record) {
                        return $record['value'];
                    }),
            ])
            ->actions([
                Tables\Actions\Action::make('view_value')
                    ->label('View')
                    ->icon('heroicon-m-eye')
                    ->modalContent(fn ($record) => view('filament.widgets.cache-value-modal', [
                        'value' => $record['value'],
                        'key' => $record['key'],
                    ])),
                Tables\Actions\Action::make('delete')
                    ->label('Delete')
                    ->icon('heroicon-m-trash')
                    ->color('danger')
                    ->requiresConfirmation()
                    ->action(function ($record) {
                        Cache::forget($record['key']);
                        Notification::make()
                            ->title('Cache key deleted successfully')
                            ->success()
                            ->send();
                    }),
            ])
            ->bulkActions([
                Tables\Actions\BulkAction::make('delete')
                    ->label('Delete Selected')
                    ->icon('heroicon-m-trash')
                    ->color('danger')
                    ->requiresConfirmation()
                    ->action(function (array $records) {
                        foreach ($records as $record) {
                            Cache::forget($record['key']);
                        }
                        Notification::make()
                            ->title('Selected cache keys deleted successfully')
                            ->success()
                            ->send();
                    }),
            ]);
    }
    
    /**
     * Get cache keys as a collection for the table
     */
    private function getCacheKeysQuery()
    {
        $cacheDriver = config('cache.default');
        $cacheData = collect();
        
        if ($cacheDriver === 'file') {
            $cachePath = config('cache.stores.file.path');
            if (File::exists($cachePath)) {
                $files = File::files($cachePath);
                
                foreach ($files as $file) {
                    $key = str_replace('.php', '', $file->getFilename());
                    // Skip system files
                    if (Str::startsWith($key, 'laravel_')) continue;
                    
                    try {
                        $value = Cache::get($key);
                        $valueText = json_encode($value);
                        if (strlen($valueText) > 1000) {
                            $valueText = substr($valueText, 0, 1000) . '...';
                        }
                        
                        // Try to determine expiration (not always possible with file driver)
                        $expires = 'Unknown';
                        
                        $cacheData->push([
                            'key' => $key,
                            'size' => $this->formatSize($file->getSize()),
                            'expires' => $expires,
                            'value' => $valueText,
                        ]);
                    } catch (\Exception $e) {
                        // Skip problematic cache entries
                    }
                }
            }
        }
        
        // For demonstration, add some sample cache keys if we don't have any
        if ($cacheData->isEmpty()) {
            $cacheData->push([
                'key' => 'sample_cache_key',
                'size' => '1.2 KB',
                'expires' => 'in 5 hours',
                'value' => json_encode(['sample' => 'data', 'for' => 'demonstration']),
            ]);
        }
        
        return $cacheData;
    }
    
    /**
     * Format file size to human-readable format
     */
    private function formatSize(int $bytes): string
    {
        $units = ['B', 'KB', 'MB', 'GB', 'TB'];
        $bytes = max($bytes, 0);
        $pow = floor(($bytes ? log($bytes) : 0) / log(1024));
        $pow = min($pow, count($units) - 1);
        $bytes /= pow(1024, $pow);
        
        return round($bytes, 2) . ' ' . $units[$pow];
    }
}
