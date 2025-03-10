<?php

namespace App\Filament\Pages;

use App\Filament\Widgets\CacheOverviewWidget;
use App\Filament\Widgets\CacheKeysWidget;
use Filament\Pages\Dashboard;
use Filament\Actions\Action;
use Illuminate\Support\Facades\Artisan;
use Filament\Notifications\Notification;
use Illuminate\Support\Facades\Cache;

class CacheDashboard extends Dashboard
{
    // Set the route path
    protected static string $routePath = '/cache-dashboard';
    
    // Set a proper title for the page
    protected static ?string $title = 'Cache Management';
    
    // Set a proper navigation label
    protected static ?string $navigationLabel = 'Cache';
    
    // Place this dashboard under System Monitoring in the navigation
    protected static ?string $navigationGroup = 'System Monitoring';
    
    // Set navigation icon
    protected static ?string $navigationIcon = 'heroicon-o-circle-stack';
    
    // Set the navigation sort order
    protected static ?int $navigationSort = 4;

    /**
     * Configure the dashboard layout
     * 
     * @return array|int
     */
    public function getColumns(): int|array
    {
        return [
            'default' => 1,
            'md' => 2,
        ];
    }

    /**
     * Define actions for the page
     * 
     * @return array
     */
    protected function getHeaderActions(): array
    {
        return [
            Action::make('clear_cache')
                ->label('Clear Cache')
                ->icon('heroicon-m-trash')
                ->color('danger')
                ->requiresConfirmation()
                ->action(function() {
                    Artisan::call('cache:clear');
                    Cache::put('cache_last_cleared', now());
                    Notification::make()
                        ->title('Cache cleared successfully')
                        ->success()
                        ->send();
                }),
                
            Action::make('clear_config')
                ->label('Clear Config Cache')
                ->icon('heroicon-m-cog')
                ->requiresConfirmation()
                ->action(function() {
                    Artisan::call('config:clear');
                    Notification::make()
                        ->title('Config cache cleared successfully')
                        ->success()
                        ->send();
                }),
                
            Action::make('clear_routes')
                ->label('Clear Route Cache')
                ->icon('heroicon-m-map')
                ->requiresConfirmation()
                ->action(function() {
                    Artisan::call('route:clear');
                    Notification::make()
                        ->title('Route cache cleared successfully')
                        ->success()
                        ->send();
                }),
                
            Action::make('clear_views')
                ->label('Clear View Cache')
                ->icon('heroicon-m-eye')
                ->requiresConfirmation()
                ->action(function() {
                    Artisan::call('view:clear');
                    Notification::make()
                        ->title('View cache cleared successfully')
                        ->success()
                        ->send();
                }),
        ];
    }

    /**
     * Define which widgets appear on the dashboard
     * 
     * @return array
     */
    public function getWidgets(): array
    {
        return [
            CacheOverviewWidget::class,
            CacheKeysWidget::class,
        ];
    }
}
