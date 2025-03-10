<?php

namespace App\Filament\Pages;

use App\Filament\Widgets\SimpleSummaryWidget;
use App\Filament\Widgets\CacheOverviewWidget;
use Filament\Pages\Dashboard as BaseDashboard;

class Dashboard extends BaseDashboard
{
    /**
     * The dashboard title
     */
    protected static ?string $title = 'System Overview';
    
    /**
     * Set navigation group
     */
    protected static ?string $navigationGroup = 'System Monitoring';
    
    /**
     * Set navigation sort (to show at top)
     */
    protected static ?int $navigationSort = 1;

    /**
     * Configure the max number of columns in the dashboard grid
     */
    public function getColumns(): int|array
    {
        return [
            'default' => 1,  // Single column on mobile
            'md' => 2,       // 2 columns from medium screens
            'lg' => 3,       // 3 columns on large screens
        ];
    }

    /**
     * Define which widgets appear on the dashboard
     */
    public function getWidgets(): array
    {
        return [
            // System overview widgets
            SimpleSummaryWidget::class,
            
            // Cache overview widget
            CacheOverviewWidget::class,
        ];
    }
}
