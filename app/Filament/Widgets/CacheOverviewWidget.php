<?php

namespace App\Filament\Widgets;

use Filament\Widgets\Widget;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\File;
use App\Helpers\SystemHelper;
use Illuminate\Support\Facades\Artisan;
use Filament\Notifications\Notification;
use Livewire\Attributes\On;

class CacheOverviewWidget extends Widget
{
    // Auto-refresh every 5 minutes
    protected static ?string $pollingInterval = '300s';
    
    // Set the column span
    protected int|string|array $columnSpan = 'full';
    
    // Set the view for the widget
    protected static string $view = 'filament.widgets.cache-overview-widget';
    
    /**
     * Clear application cache
     */
    #[On('clear-application-cache')]
    public function clearApplicationCache()
    {
        Artisan::call('cache:clear');
        Cache::put('cache_last_cleared', now());
        
        Notification::make()
            ->title('Application cache cleared successfully')
            ->success()
            ->send();
            
        $this->dispatch('cache-cleared');
    }
    
    /**
     * Clear config cache
     */
    #[On('clear-config-cache')]
    public function clearConfigCache()
    {
        Artisan::call('config:clear');
        
        Notification::make()
            ->title('Config cache cleared successfully')
            ->success()
            ->send();
            
        $this->dispatch('cache-cleared');
    }
    
    /**
     * Clear route cache
     */
    #[On('clear-route-cache')]
    public function clearRouteCache()
    {
        Artisan::call('route:clear');
        
        Notification::make()
            ->title('Route cache cleared successfully')
            ->success()
            ->send();
            
        $this->dispatch('cache-cleared');
    }
    
    /**
     * Clear view cache
     */
    #[On('clear-view-cache')]
    public function clearViewCache()
    {
        Artisan::call('view:clear');
        
        Notification::make()
            ->title('View cache cleared successfully')
            ->success()
            ->send();
            
        $this->dispatch('cache-cleared');
    }
    
    /**
     * Get cache driver information
     */
    public function getCacheDriverInfo()
    {
        // Get cache driver information
        $cacheDriver = config('cache.default');
        $cacheConfig = config('cache.stores.' . $cacheDriver);
        
        return [
            'driver' => ucfirst($cacheDriver),
            'type' => $cacheConfig['driver'] ?? $cacheDriver,
        ];
    }
    
    /**
     * Get cache size information
     */
    public function getCacheSizeInfo()
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
            
            return [
                'size' => SystemHelper::formatBytes($size),
                'entries' => $entries,
            ];
        } catch (\Exception $e) {
            return [
                'size' => '0 B',
                'entries' => 0,
            ];
        }
    }
    
    /**
     * Get environment information
     */
    public function getEnvironmentInfo()
    {
        return [
            'name' => app()->environment(),
            'debug' => config('app.debug') ? 'Debug On' : 'Debug Off',
        ];
    }
}
