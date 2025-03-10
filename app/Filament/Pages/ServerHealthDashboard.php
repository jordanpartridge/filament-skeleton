<?php

namespace App\Filament\Pages;

use App\Filament\Widgets\ServerInfoWidget;
use Filament\Pages\Dashboard;

class ServerHealthDashboard extends Dashboard
{
    // Set the route path
    protected static string $routePath = '/server-health';
    
    // Set a proper title for the page
    protected static ?string $title = 'Server Health';
    
    // Set a proper navigation label
    protected static ?string $navigationLabel = 'Server Health';
    
    // Place this dashboard under System Monitoring navigation group
    protected static ?string $navigationGroup = 'System Monitoring';
    
    // Set the navigation sort order
    protected static ?int $navigationSort = 2;

    // Configure the dashboard layout - use integer instead of 'full' to avoid the error
    public function getColumns(): int|array
    {
        return 1;
    }

    // Define which widgets appear on the dashboard
    public function getWidgets(): array
    {
        return [
            // Comprehensive server metrics
            ServerInfoWidget::class,
        ];
    }
}
