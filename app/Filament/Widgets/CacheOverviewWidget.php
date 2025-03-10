<?php

namespace App\Filament\Widgets;

use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\File;
use App\Helpers\SystemHelper;
use Illuminate\Support\Facades\Artisan;
use Filament\Notifications\Notification;

class CacheOverviewWidget extends BaseWidget
{
    // Auto-refresh every 5 minutes
    protected static ?string $pollingInterval = '300s';
    
    // Set the column span
    protected int|string|array $columnSpan = 'full';
    
    /**
     * Get the stats for the widget
     */
    protected function getStats(): array
    {
        // Get cache driver information
        $cacheDriver = config('cache.default');
        $cacheConfig = config('cache.stores.' . $cacheDriver);
        
        // Get size information (if file driver)
        $cacheSize = '0 B';
        $cacheEntries = 0;
        
        if ($cacheDriver === 'file') {
            $cachePath = config('cache.stores.file.path');
            if (File::exists($cachePath)) {
                $files = File::files($cachePath);
                $cacheEntries = count($files);
                
                $totalSize = 0;
                foreach ($files as $file) {
                    $totalSize += $file->getSize();
                }
                
                $cacheSize = SystemHelper::formatBytes($totalSize);
            }
        }
        
        return [
            Stat::make('Cache Driver', ucfirst($cacheDriver))
                ->description('Type: ' . ($cacheConfig['driver'] ?? $cacheDriver))
                ->descriptionIcon('heroicon-m-cube')
                ->color('primary'),
                
            Stat::make('Cache Size', $cacheSize)
                ->description($cacheEntries . ' entries')
                ->descriptionIcon('heroicon-m-document')
                ->color('info'),
                
            Stat::make('Cache Actions', 'Clear Now')
                ->description('Flush application cache')
                ->descriptionIcon('heroicon-m-trash')
                ->color('danger'),
                
            Stat::make('Environment', app()->environment())
                ->description('Application mode')
                ->descriptionIcon('heroicon-m-cog')
                ->color('warning'),
        ];
    }
}
