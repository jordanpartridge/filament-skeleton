<?php

namespace App\Filament\Pages;

use App\Filament\Widgets\UserStatsWidget;
use App\Filament\Widgets\RecentActivityWidget;
use Dotswan\FilamentLaravelPulse\Widgets\PulseCache;
use Dotswan\FilamentLaravelPulse\Widgets\PulseExceptions;
use Dotswan\FilamentLaravelPulse\Widgets\PulseQueues;
use Dotswan\FilamentLaravelPulse\Widgets\PulseServers;
use Dotswan\FilamentLaravelPulse\Widgets\PulseUsage;
use Filament\Pages\Dashboard as BaseDashboard;

class Dashboard extends BaseDashboard
{
    /**
     * The dashboard title
     */
    protected static ?string $title = 'System Dashboard';

    /**
     * Configure the max number of columns in the dashboard grid
     * This method is documented in Filament 3.x
     */
    public function getColumns(): int|string|array
    {
        // Consistently keep it to 2 columns maximum
        return [
            'default' => 1, // Single column on mobile
            'md' => 2,      // 2 columns from medium screens up
        ];
    }

    /**
     * Define which widgets appear on the dashboard
     */
    public function getWidgets(): array
    {
        return [
            // Stats widget at the top
            // User stats moved to User Dashboard
            
            // Server metrics as a full-width widget
            PulseServers::class,
            
            // Side-by-side metrics
            PulseCache::class,
            PulseQueues::class,
            
            // Side-by-side metrics
            PulseUsage::class,
            PulseExceptions::class,
            
            // Full-width activity log at the bottom
            RecentActivityWidget::class,
        ];
    }
}
