<?php

namespace App\Filament\Widgets;

use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\File;
use App\Helpers\SystemHelper;
use Carbon\Carbon;
use Filament\Notifications\Notification;

class CacheOverviewWidget extends BaseWidget
{
    // Auto-refresh every 5 minutes
    protected static ?string $pollingInterval = '300s';
    
    // Set the column span
    protected int|string|array $columnSpan = 'full';
    
    // Add a Livewire listener for the clear cache action
    protected $listeners = ['clear-cache' => 'clearCache'];
    
    /**
     * Clear the application cache
     */
    public function clearCache()
    {
        Artisan::call('cache:clear');
        Cache::put('cache_last_cleared', now());
        Notification::make()
            ->title('Cache cleared successfully')
            ->success()
            ->send();
        
        // Refresh the widget
        $this->refresh();
    }
    
    /**
     * Get the stats for the widget
     */
    protected function getStats(): array
    {
        // Get cache driver information
        $cacheDriver = config('cache.default');
        $cacheConfig = config('cache.stores.' . $cacheDriver);
        
        // Get cache size information
        $cacheSize = $this->getCacheSize();
        
        // Get cache last cleared time (stored in cache)
        $lastCleared = Cache::get('cache_last_cleared', 'Unknown');
        if ($lastCleared !== 'Unknown') {
            $lastCleared = Carbon::parse($lastCleared)->diffForHumans();
        }
        
        // Get cache entry count (approximate)
        $cacheEntryCount = $this->getCacheEntryCount();
        
        // Get cache hit ratio if available
        $cacheHitRatio = Cache::get('cache_hit_ratio', null);
        $hitRatioValue = $cacheHitRatio ? round($cacheHitRatio * 100) . '%' : 'N/A';
        
        return [
            Stat::make('Cache Driver', ucfirst($cacheDriver))
                ->description('Type: ' . ($cacheConfig['driver'] ?? $cacheDriver))
                ->descriptionIcon('heroicon-m-cube')
                ->color('primary')
                ->extraAttributes([
                    'class' => 'cursor-pointer',
                    'wire:click' => '$dispatch("open-modal", { id: "cache-info-modal" })',
                ]),
                
            Stat::make('Cache Size', $cacheSize['formatted'])
                ->description($cacheSize['entries'] . ' files')
                ->descriptionIcon('heroicon-m-document')
                ->color('info')
                ->extraAttributes([
                    'class' => 'cursor-pointer',
                    'wire:click' => '$dispatch("open-modal", { id: "cache-files-modal" })',
                ]),
                
            Stat::make('Last Cleared', $lastCleared)
                ->description('Clear cache →')
                ->descriptionIcon('heroicon-m-trash')
                ->color('success')
                ->extraAttributes([
                    'class' => 'cursor-pointer',
                    'wire:click' => '$dispatch("clear-cache")',
                ]),
                
            Stat::make('Hit Ratio', $hitRatioValue)
                ->description('Cache performance')
                ->descriptionIcon('heroicon-m-bolt')
                ->color('warning')
                ->chart($cacheHitRatio ? [
                    $cacheHitRatio * 100 - 10,
                    $cacheHitRatio * 100 - 5, 
                    $cacheHitRatio * 100 - 2,
                    $cacheHitRatio * 100
                ] : [50, 55, 60, 65]),
        ];
    }
    
    /**
     * Get cache size information
     * 
     * @return array
     */
    private function getCacheSize(): array
    {
        $cacheDriver = config('cache.default');
        $size = 0;
        $entries = 0;
        
        try {
            if ($cacheDriver === 'file') {
                $cachePath = config('cache.stores.file.path');
                if (File::exists($cachePath)) {
                    $files = File::files($cachePath);
                    $entries = count($files);
                    
                    foreach ($files as $file) {
                        $size += $file->getSize();
                    }
                }
            }
            
            // For other drivers, just use a placeholder for now
            // In a real app, you might query Redis or Memcached for actual size
            
            return [
                'bytes' => $size,
                'formatted' => SystemHelper::formatBytes($size),
                'entries' => $entries,
            ];
        } catch (\Exception $e) {
            return [
                'bytes' => 0,
                'formatted' => SystemHelper::formatBytes(0),
                'entries' => 0,
            ];
        }
    }
    
    /**
     * Get approximate cache entry count
     * 
     * @return int
     */
    private function getCacheEntryCount(): int
    {
        $cacheDriver = config('cache.default');
        
        try {
            if ($cacheDriver === 'file') {
                $cachePath = config('cache.stores.file.path');
                if (File::exists($cachePath)) {
                    return count(File::files($cachePath));
                }
            } elseif ($cacheDriver === 'redis') {
                // For Redis, you'd need the phpredis extension and use something like:
                // $redis = Cache::getRedis();
                // return $redis->dbSize();
            } elseif ($cacheDriver === 'memcached') {
                // For Memcached, you'd need similar specific code
            }
            
            // Default fallback
            return 0;
        } catch (\Exception $e) {
            return 0;
        }
    }
}
